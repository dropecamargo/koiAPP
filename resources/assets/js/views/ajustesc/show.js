/**
* Class ShowAjustecView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ShowAjustecView = Backbone.View.extend({

        el: '#ajustec-show',
        /**
        * Constructor Method
        */
        initialize : function() {
            // Model exist
            if( this.model.id != undefined ) {
            	this.detalleAjustec = new app.AjustecDetalleList();
                
                // Reference views
                this.referenceViews();
            }
        },

        /**
        * reference to views
        */
        referenceViews: function () {
    		// Detalle ajustec list
            this.detalleAjustecView = new app.DetalleAjustecView({
                collection: this.detalleAjustec,
                parameters: {
                    wrapper: this.el,
                    edit: false,
                    dataFilter: {
                    	ajustec: this.model.get('id')
                    }
                }
            });
        }
    });
})(jQuery, this, this.document);
