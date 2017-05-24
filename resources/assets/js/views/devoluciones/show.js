/**
* Class ShowDevolucionView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ShowDevolucionView = Backbone.View.extend({

        el: '#devolucion-show',

        events:{
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            // Attributes
            this.$wraperForm = this.$('#render-devolucion-show');
            // Model exist
            if( this.model.id != undefined ) {

                this.detalleDevolucion = new app.DevolucionDetalleCollection();

                // Reference views
                this.referenceViews();
            }
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            // Detalle devolucion list
            this.itemsListView = new app.DevolucionDetalle2View({
                collection: this.detalleDevolucion,
                parameters: {
                    wrapper: this.el,
                    edit: false,
                    dataFilter: {
                        id: this.model.get('id')
                    }
                }
            });
        }
    });

})(jQuery, this, this.document);
