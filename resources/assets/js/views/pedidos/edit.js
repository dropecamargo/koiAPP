    /**
* Class EditPedidoView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.EditPedidoView = Backbone.View.extend({
        el: '#pedido-create',
        template: _.template(($('#add-pedido-tpl').html() || '') ),
        events: {
            'click .submit-pedido' :'submitPedido',
            'click .close-pedido' :'closePedido',
            'click .cancel-pedido' :'cancelPedido',
            'submit #form-pedido' :'onStore',
            'submit #form-detalle-pedido' :'onStoreDetalle'
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            // Attributes
            this.$wraperForm = this.$('#render-form-pedido');

            this.detallePedido = new app.DetallePedidoCollection();
            this.bitacora = new app.BitacoraCollection();

            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /**
        * Render View Element
        */
        render: function() {
            var attributes = this.model.toJSON();
                attributes.edit = true;

            this.$wraperForm.html( this.template(attributes) );
            this.$form = this.$('#form-pedido');
            this.$formItem = this.$('#form-detalle-pedido');

            // Reference views
            this.referenceViews();
            this.ready();
        },

     	/**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();

            if( typeof window.initComponent.initICheck == 'function' )
                window.initComponent.initICheck();

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
        * reference to views
        */
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
        * Event submit Pedido
        */
        submitPedido: function (e) {
            this.$form.submit();
        },

        /**
        * Event Create Pedido
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                this.model.save( data, {patch: true, silent: true} );
            }
        },
        /**
        * Event Create DetallePedido
        */
        onStoreDetalle: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                this.detallePedido.trigger('store' , data);
            }
        },

        /**
        * Close pedido
        */
        closePedido: function (e) {
            e.preventDefault();

            var _this = this;
            var cancelConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: { id_pedido: _this.model.get('id') },
                    template: _.template( ($('#pedido-close-confirm-tpl').html() || '') ),
                    titleConfirm: 'Cerrar Pedido',
                    onConfirm: function () {
                        // Close pedido
                        $.ajax({
                            url: window.Misc.urlFull( Route.route('pedidos.cerrar', { pedidos: _this.model.get('id') }) ),
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

                                window.Misc.successRedirect( resp.msg, window.Misc.urlFull(Route.route('pedidos.show', { pedidos: _this.model.get('id') })) );
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

                // Redirect to edit pedido
               window.Misc.redirect( window.Misc.urlFull(Route.route('pedidos.edit', { pedidos: resp.id})));
            }
        }
    });
})(jQuery, this, this.document);
