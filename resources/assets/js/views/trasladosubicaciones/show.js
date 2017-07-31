/**
* Class ShowTrasladoUbicacionView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ShowTrasladoUbicacionView = Backbone.View.extend({

        el: '#trasladosubicaciones-show',

        /**
        * Constructor Method
        */
        initialize : function() {
            // Model exist
            if( this.model.id != undefined ) {

                this.trasladoUbicacionesList = new app.TrasladoUbicacionesList();

                // Reference views
                this.referenceViews();
            }
        },

        /**
        * Reference to views
        */
        referenceViews: function () {
    		// Detalle traslado list
            this.productosListView = new app.TrasladoUbicacionesListView({
                collection: this.trasladoUbicacionesList,
                parameters: {
                    wrapper: this.el,
                    edit: false,
                    dataFilter: {
                    	traslado: this.model.get('id')
                    }
                }
            });
        }
    });

})(jQuery, this, this.document);
