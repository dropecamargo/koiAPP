/**
* Class CreateReciboView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateReciboView = Backbone.View.extend({

        el: '#recibo1-create',
        template: _.template(($('#add-recibo1-tpl').html() || '') ),
        events: {
            'click .submit-recibo' :'submitFormRecibo',
            'submit #form-recibo1' :'onStore',
            'submit #form-recibo2' :'onStoreItem',
            'change .change-concepto' :'changeConcepto'
        },
        parameters: {
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            // Initialize
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            // Attributes
            this.$wraperForm = this.$('#render-form-recibo1');
            this.detalleReciboList = new app.DetalleReciboList();

            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );            
            
            this.ready();
        },


        /*
        * Render View Element
        */
        render: function() {
            var attributes = this.model.toJSON();
            this.$wraperForm.html( this.template(attributes) );
            this.$form = this.$('#form-recibo1');
            
            this.referenceViews();
        },

        /**
        * Event submit recibo1
        */
        submitFormRecibo: function (e) {
            this.$form.submit();
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            //DetalleReciboList
            this.detalleRecibosView = new app.DetalleRecibosView( {
                collection: this.detalleReciboList,
                parameters: {
                    wrapper: this.$('#wrapper-recibo2'),
                    edit: true,
                    dataFilter: {
                        'recibo2': this.model.get('id')
                    }
               }
            });
        },

        /*
        * Event Create recibo
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();
                var data = window.Misc.formToJson( e.target );
                data.recibo2 = this.detalleReciboList.toJSON();
                this.model.save( data, {patch: true, silent: true} );
            }   
        },

        changeConcepto: function(e){
            var data = window.Misc.formToJson( e.target );

            window.Misc.evaluateActionsCartera({
                'data': data,
                'wrap': this.$el,
                'callback': (function (_this) {
                    return function ( action , tipo)
                    {      
                        // Open CarteraActionView
                        if ( _this.carteraActionView instanceof Backbone.View ){
                            _this.carteraActionView.stopListening();
                            _this.carteraActionView.undelegateEvents();
                        }

                        _this.carteraActionView = new app.CarteraActionView({
                            model: _this.model,
                            collection: _this.detalleReciboList,
                            parameters: {
                                data: data,
                                action: action,
                                tipo: tipo
                            }
                        });
                        _this.carteraActionView.render();
                    }
                })(this)
            });
        },

        /**
        * Event add item detalle traslado
        */
        onStoreItem: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                this.detalleReciboList.trigger( 'store', this.$(e.target) );
            }
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();

            if( typeof window.initComponent.initInputMask == 'function' )
                window.initComponent.initInputMask();
            
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();
            
            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();
            

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
            window.Misc.redirect( window.Misc.urlFull( Route.route('recibos.show', { recibos: resp.id}), { trigger:true }) );
        }
    });

})(jQuery, this, this.document);
