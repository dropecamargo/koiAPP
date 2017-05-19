/**
* Class ShowFacturaView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ShowFacturaView = Backbone.View.extend({

        el: '#factura-show',

        events:{
            'click .anular-factura': 'anularFactura',
            'click .export-factura': 'exportFactura'
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            // Attributes
            this.$wraperForm = this.$('#render-factura-show');
            this.$templateFactura3 = _.template( ($('#add-factura3-item-tpl').html() || '') ); 
            // Model exist
            if( this.model.id != undefined ) {

                this.detalleFactura = new app.DetalleFactura2Collection();
                this.detalleFacturaList = new app.DetalleFactura3List();

                // Reference views
                this.referenceViews();
            }
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            // Detalle factura list
            this.itemsListView = new app.FacturaDetalle2View({
                collection: this.detalleFactura,
                parameters: {
                    wrapper: this.el,
                    edit: false,
                    dataFilter: {
                        id: this.model.get('id')
                    }
                }
            });

            // Detalle list
            this.Factura3ListView = new app.Factura3ListView({
                collection: this.detalleFacturaList,
                parameters: {
                    wrapper: this.el,
                    edit: false,
                    call: 'detalle',
                    template : this.$templateFactura3,
                    dataFilter: {
                        'factura1': this.model.get('id'),
                    }
                }
            });
        },

        /*
        * Redirect anular factura
        */  
        anularFactura:function(e){
            e.preventDefault();
            var _this = this;
            var anularConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: { id: _this.model.get('id') },
                    template: _.template( ($('#factura-close-confirm-tpl').html() || '') ),
                    titleConfirm: 'Anular factura de venta',
                    onConfirm: function () {
                        // Anular factura
                        $.ajax({
                            url: window.Misc.urlFull( Route.route('facturas.anular', { facturas: _this.model.get('id') }) ),
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

                                window.Misc.successRedirect( resp.msg, window.Misc.urlFull(Route.route('facturas.show', { facturas: _this.model.get('id') })) );
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

        /*
        * Redirect export pdf
        */
        exportFactura:function(e){
        }
    });

})(jQuery, this, this.document);
