/**
* Class TipoActividadModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.TipoActividadModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('tiposactividad.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'tipoactividad_nombre': '',
        	'tipoactividad_activo': false,
        	'tipoactividad_comercial': false,
        	'tipoactividad_tecnico': false,
        	'tipoactividad_cartera': false
        }
    });

})(this, this.document);
