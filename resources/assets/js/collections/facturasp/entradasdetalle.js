/**
* Class EntradasList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.EntradasList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('entradas.detalle.index') );
        },
        model: app.EntradaDetalleModel,

        /**
        * Constructor Method
        */
        initialize : function(){
        },
   });

})(this, this.document);