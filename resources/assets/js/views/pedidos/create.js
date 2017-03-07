/**
* Class CreatePedidoView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreatePedidoView = Backbone.View.extend({

        el: '#pedido-create',
        template: _.template(($('#add-pedido-tpl').html() || '') ),
        events: {
            'submit #form-pedido' :'onStore',
        },
        parameters: {
        },

        /**
        * Constructor Method
        */
        initialize : function() {
           
            // Attributes
            this.$wraperForm = this.$('#render-form-pedido');
            
            this.detallePedido = new app.DetallePedidoCollection();
            
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
            attributes.edit = false;
            this.$wraperForm.html( this.template(attributes) );
            this.$form = this.$('#form-pedido');
            this.$formItem = this.$('#form-detalle-pedido');

            // Reference views
            this.referenceViews();
            
            this.ready();
        },

        referenceViews:function(){ 

            this.detallePedidosView = new app.DetallePedidosView( {
                collection: this.detallePedido,
                parameters: {
                    edit: true,
                    wrapper: this.el,
                    dataFilter: {
                        'pedido_id': this.model.get('id')
                    }
               }
            });
        },

        /**
        * Event Create Pedido
        */
        onStore: function (e) {

            if (!e.isDefaultPrevented()) {
                e.preventDefault();
                var data = window.Misc.formToJson( e.target );
                data.pedido_id = this.model.get('id');  
                this.model.save( data, {patch: true, silent: true} );
            }
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initICheck == 'function' )
                window.initComponent.initICheck(); 

            if( typeof window.initComponent.initInputMask == 'function' )
                window.initComponent.initInputMask();
            
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

                // EditPedidoView undelegateEvents
                if ( this.editPedidoView instanceof Backbone.View ){
                    this.editPedidoView.stopListening();
                    this.editPedidoView.undelegateEvents();
                }

                // Redirect to edit pedido
                Backbone.history.navigate(Route.route('pedidos.edit', { pedidos: resp.pedido_id}), { trigger:true });
            }
        }
    });

})(jQuery, this, this.document);
