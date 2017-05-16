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
        }
    });

})(jQuery, this, this.document);
