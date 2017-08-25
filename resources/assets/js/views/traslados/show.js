/**
* Class ShowTrasladoView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ShowTrasladoView = Backbone.View.extend({

        el: '#traslados-show',
        events: {
            'click .export-traslado': 'exportTraslado',
        },
        /**
        * Constructor Method
        */
        initialize : function() {
            // Model exist
            if( this.model.id != undefined ) {

            	this.trasladoProductosList = new app.TrasladoProductosList();

                // Reference views
                this.referenceViews();
            }
        },

        /**
        * reference to views
        */
        referenceViews: function () {
    		// Detalle traslado list
            this.productosListView = new app.TrasladoProductosListView({
                collection: this.trasladoProductosList,
                parameters: {
                    wrapper: this.el,
                    edit: false,
                    dataFilter: {
                    	traslado: this.model.get('id')
                    }
                }
            });
        }, 

        /*
        * Redirect export pdf
        */
        exportTraslado:function(e){
            e.preventDefault(); 

            // Redirect to pdf
            window.open( window.Misc.urlFull( Route.route('traslados.exportar', { traslados: this.model.get('id') })) );
        }
    });

})(jQuery, this, this.document);
