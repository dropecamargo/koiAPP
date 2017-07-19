/**
* Class UbicacionModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.UbicacionModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('ubicaciones.index') );
        },
        idAttribute: 'id',
        defaults: {
            'ubicacion_nombre': '',
            'ubicacion_activo': 1,
            'ubicacion_sucursal': '',
        	'ubicacion_select': '',
        }
    });

})(this, this.document);
