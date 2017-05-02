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
        }
    });

})(jQuery, this, this.document);
