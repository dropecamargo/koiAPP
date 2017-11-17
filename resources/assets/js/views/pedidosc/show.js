/**
* Class ShowPedidocView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ShowPedidocView = Backbone.View.extend({

        el: '#pedidoc-show',
        events: {
            'click .anular-pedidoc': 'anularFactura',
            'click .export-pedidoc': 'exportPedido',
            'click .authco-pedidoc': 'authCoPedido'
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            // Attributes
            this.$wraperForm = this.$('#render-pedidoc-show');

            // Model exist
            if( this.model.id != undefined ) {
                this.detallePedidoc = new app.PedidocDetalleCollection();
                
                // Reference views
                this.referenceViews();
            }
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            // Detalle pedidoc list
            this.itemsListView = new app.PedidocDetalleView({
                collection: this.detallePedidoc,
                parameters: {
                    wrapper: this.el,
                    edit: false,
                    dataFilter: {
                        id: this.model.get('id')
                    }
                }
            });
        },

        /*
        * Redirect export pdf
        */
        exportPedido:function(e){
            e.preventDefault(); 

            // Redirect to pdf
            window.open( window.Misc.urlFull( Route.route('pedidosc.exportar', { pedidosc: this.model.get('id') })) );
        },

        /*
        * Redirect anular pedido comercial
        */  
        anularFactura:function(e){
            e.preventDefault();
            var _this = this;
            var anularConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: { 
                        id: _this.model.get('id') 
                    },
                    template: _.template( ($('#pedidoc-close-confirm-tpl').html() || '') ),
                    titleConfirm: 'Anular pedido comercial',
                    onConfirm: function () {
                        // Anular pediodc
                        $.ajax({
                            url: window.Misc.urlFull( Route.route('pedidosc.anular', { pedidosc: _this.model.get('id') }) ),
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

                                window.Misc.successRedirect( resp.msg, window.Misc.urlFull(Route.route('pedidosc.show', { pedidosc: _this.model.get('id') })) );
                            }
                        })
                        .fail(function(jqXHR, ajaxOptions, thrownError) {
                            window.Misc.removeSpinner( _this.el );
                            alertify.error(thrownError);
                        });
                    }
                }
            });
            anularConfirm.render();
        },
        /**
        *
        */
        authCoPedido: function(e){
            e.preventDefault();
            var authorization = new window.app.AuthorizationsWindow({
                parameters: {
                    dataFilter: { 
                        id: this.model.get('id'),
                        call: 'autorizaco' 
                    },
                    template: _.template( ($('#add-autorizaco-tpl').html() || '') ),
                    titleConfirm: 'Autorización comercial de pedido comercial',
                }
            });
            authorization.render();
        },
    });

})(jQuery, this, this.document);
