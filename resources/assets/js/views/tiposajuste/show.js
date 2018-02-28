/**
* Class ShowTipoAjusteView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ShowTipoAjusteView = Backbone.View.extend({

        el: '#tipoajuste-show',

        /**
        * Constructor Method
        */
        initialize : function() {
            this.detalleTipoAjusteList = new app.DetalleTipoAjusteList();

            // Reference views
            this.referenceViews();
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            // Detalle tipoajuste list
            this.detalleTipoAjusteListView = new app.DetalleTipoAjusteListView({
                collection: this.detalleTipoAjusteList,
                parameters: {
                    wrapper: this.el,
                    edit: false,
                    dataFilter: {
                        tipoajuste: this.model.get('id')
                    }
                }
            });
        },
    });

})(jQuery, this, this.document);
