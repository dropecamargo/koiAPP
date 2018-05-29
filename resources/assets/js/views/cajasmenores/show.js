/**
* Class ShowCajaMenorView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ShowCajaMenorView = Backbone.View.extend({

        el: '#cajamenor-show',
        events:{
        },
        /**
        * Constructor Method
        */
        initialize : function() {
            // Model exist
            if( this.model.id != undefined ) {
                this.detalleCajaMenor = new app.CajaMenorDetalleList();

                // Reference views
                this.referenceViews();
            }
        },

        /**
        * reference to views
        */
        referenceViews: function () {
    		// Detalle ajustec list
            this.detalleCajaMenorView = new app.DetalleCajaMenorView({
                collection: this.detalleCajaMenor,
                parameters: {
                    edit: false,
                    dataFilter: {
                    	cajamenor: this.model.get('id')
                    }
                }
            });
        },
    });
})(jQuery, this, this.document);
