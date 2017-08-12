/**
* Class TipoActivoModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.TipoActivoModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('tipoactivos.index') );
        },
        idAttribute: 'id',
        defaults: {
            'tipoactivo_nombre': '',
            'tipoactivo_activo': 1,
            'tipoactivo_vida_util': 1,
            'plancuentas_cuenta': '',
            'plancuentas_nombre': ''
        }
    });

})(this, this.document);
