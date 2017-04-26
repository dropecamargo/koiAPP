/**
* Class CreatePedidoscView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreatePedidoscView = Backbone.View.extend({

        el: '#pedidosc-create',
        template: _.template(($('#add-pedidosc-tpl').html() || '') ),
        templateDetailt: _.template(($('#add-detailt-pedidosc-tpl').html() || '') ),

        events: {
            
            'click .submit-pedidosc' : 'submitForm',
            'submit #form-pedidoc1' :'onStore',
            'submit #form-detalle-pedidoc' :'onStoreItem'
        },
        parameters: {
        },

        /**
        * Constructor Method
        */
        initialize : function() {
           
            // Attributes
            this.$wraperForm = this.$('#render-form-pedidosc');

            this.detallePedidoc = new app.PedidocDetalleCollection();
            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );            
        },


        /*
        * Render View Element
        */
        render: function() {
                        
            var attributes = this.model.toJSON();
            this.$wraperForm.html( this.template(attributes) );

            this.$form = this.$('#form-pedidoc1');
            this.$divDetalle = this.$('#detalle-pedidoc1');

            //Render form detalle pedidoc
            this.$divDetalle.empty().html( this.templateDetailt( ) );

            //Reference views
            this.referenceViews();
            this.ready(); 
        },
        /*
        *References the collection
        */
        referenceViews:function(){ 
            this.detallePedidocView = new app.PedidocDetalleView( {
                collection: this.detallePedidoc,
                parameters: {
                    wrapper: this.el,
                    edit: true,
                    dataFilter: {
                        'id': this.model.get('id')
                    }
               }
            });
        },
        /**
        * Event submit pedidoc1
        */
        submitForm: function (e) {
            this.$form.submit();
        },

        /**
        * Event Create Ajuste
        */
        onStore: function (e) {
            
            if (!e.isDefaultPrevented()) {
                e.preventDefault();
                var data = window.Misc.formToJson( e.target );
                this.model.save( data, {patch: true, silent: true} );
            }   
        },
        /**
        *
        */
        onStoreItem: function(e){
            if (!e.isDefaultPrevented()) {
                e.preventDefault();
                this.detallePedidoc.trigger( 'store', this.$(e.target) );
            }
        },
        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();
            
            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();
            
            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();

            if( typeof window.initComponent.initDatePicker == 'function' )
                window.initComponent.initDatePicker();
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (model, xhr, opts) {
            window.Misc.setSpinner( this.el );
            
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            window.Misc.removeSpinner( this.el );

            if(!_.isUndefined(resp.success)) {
                // response success or error
                var text = resp.success ? '' : resp.errors;
                if( _.isObject( resp.errors ) ) {
                    text = window.Misc.parseErrors(resp.errors);
                }

                if( !resp.success ) {
                    alertify.error(text);
                    return; 
                }
            }
            window.Misc.redirect( window.Misc.urlFull( Route.route('pedidosc.index')) );
        }
    });

})(jQuery, this, this.document);
