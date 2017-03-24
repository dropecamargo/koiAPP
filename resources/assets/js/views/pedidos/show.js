/**
* Class ShowPedidoView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ShowPedidoView = Backbone.View.extend({

        el: '#pedido-show',
        template: _.template(($('#show-pedido-tpl').html() || '') ),
        events: {
            'click .cancel-pedido' :'cancelPedido'
        },

        /**
        * Constructor Method
        */
        initialize : function() {

            // Attributes
            this.$wraperForm = this.$('#render-pedido-show');

            // Model exist
            if( this.model.id != undefined ) {
                this.detallePedido = new app.DetallePedidoCollection();
                this.bitacora = new app.BitacoraCollection();
            }
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

            // Reference views
            this.referenceViews();
            
            this.ready();
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            
            //Detalle Pedido view Collection
            this.detallePedidosView = new app.DetallePedidosView( {
                collection: this.detallePedido,
                parameters: {
                    edit: false,
                    wrapper: this.el,
                    dataFilter: {
                        'pedido_id': this.model.get('id')
                    }
               }
            }); 
            
            //Bitacora view Collection
            this.bitacoraView = new app.BitacoraView( {
                collection: this.bitacora,
                parameters: {
                    edit: true,
                    wrapper: this.el,
                    dataFilter: {
                        'document_id': this.model.get('id'),
                        'document_type': this.model.get('pedido1_documentos')
                    }
               }
            });
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
        * Cancel pedido
        */
        cancelPedido: function (e) {
            e.preventDefault();

            var _this = this;
            var cancelConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: { id_pedido: _this.model.get('id') },
                    template: _.template( ($('#pedido-cancel-confirm-tpl').html() || '') ),
                    titleConfirm: 'Anular Pedido',
                    onConfirm: function () {
                        // Cancel pedido
                        $.ajax({
                            url: window.Misc.urlFull( Route.route('pedidos.anular', { pedidos: _this.model.get('id') }) ),
                            type: 'GET',
                            beforeSend: function() {
                                window.Misc.setSpinner( _this.el );
                            }
                        })
                        .done(function(resp) {
                            window.Misc.removeSpinner( _this.el );

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

                                window.Misc.successRedirect( resp.msg, window.Misc.urlFull(Route.route('pedidos.index')) );
                            }
                        })
                        .fail(function(jqXHR, ajaxOptions, thrownError) {
                            window.Misc.removeSpinner( _this.el );
                            alertify.error(thrownError);
                        });
                    }
                }
            });

            cancelConfirm.render();
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
        }
    });

})(jQuery, this, this.document);
