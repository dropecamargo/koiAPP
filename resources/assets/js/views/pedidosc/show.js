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
            'click .export-pedidoc': 'exportPedido',
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
        }
    });

})(jQuery, this, this.document);
