/**
* Class ShowNotaView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ShowNotaView = Backbone.View.extend({

        el: '#nota-show',
        /**
        * Constructor Method
        */
        initialize : function() {
            // Model exist
            if( this.model.id != undefined ) {
            	this.detalleNotaList = new app.DetalleNotaList();
                
                // Reference views
                this.referenceViews();
            }
        },

        /**
        * reference to views
        */
        referenceViews: function () {
    		// Detalle asignaciones list
            this.detalleNotasView = new app.DetalleNotasView({
                collection: this.detalleNotaList,
                parameters: {
                    wrapper: this.el,
                    edit: false,
                    dataFilter: {
                    	nota2: this.model.get('id')
                    }
                }
            });
        }
    });
})(jQuery, this, this.document);
