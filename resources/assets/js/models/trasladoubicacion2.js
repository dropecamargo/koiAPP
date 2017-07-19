/**
* Class TrasladoUbicacion2Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.TrasladoUbicacion2Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('trasladosubicaciones.detalle.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'trasladou2_cantidad': '',
        }
    });

})(this, this.document);