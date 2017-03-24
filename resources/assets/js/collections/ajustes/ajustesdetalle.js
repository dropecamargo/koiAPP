/**
* Class AjustesDetalleCollection of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.AjustesDetalleCollection = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('ajustes.detalle.index') );
        },
        model: app.AjusteDetalleModel,

        /**
        * Constructor Method
        */
        initialize : function(){
        }
   });

})(this, this.document);