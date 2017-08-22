/**
* Class ShowAjustepView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ShowAjustepView = Backbone.View.extend({

        el: '#ajustep-show',
        events:{
            'click .export-ajustep': 'exportAjustep'
        },
        /**
        * Constructor Method
        */
        initialize : function() {
            // Model exist
            if( this.model.id != undefined ) {
                this.detalleAjustep = new app.AjustepDetalleList();

                // Reference views
                this.referenceViews();
            }
        },

        /**
        * reference to views
        */
        referenceViews: function () {
    		// Detalle ajustec list
            this.detalleAjustepView = new app.DetalleAjustepView({
                collection: this.detalleAjustep,
                parameters: {
                    wrapper: this.el,
                    edit: false,
                    dataFilter: {
                    	ajustep: this.model.get('id')
                    }
                }
            });
        },

        /*
        * Redirect export pdf
        */
        exportAjustep:function(e){
            e.preventDefault();

            // Redirect to pdf
            window.open( window.Misc.urlFull( Route.route('ajustesp.exportar', { ajustesp: this.model.get('id') })) );
        },
    });
})(jQuery, this, this.document);
