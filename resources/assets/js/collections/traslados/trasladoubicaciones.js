/**
* Class TrasladoUbicacionesList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.TrasladoUbicacionesList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('trasladosubicaciones.detalle.index') );
        },
        model: app.TrasladoUbicacion2Model,

        /**
        * Constructor Method
        */
        initialize : function() {

        }
   });

})(this, this.document);