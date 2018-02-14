/**
* Class TipoGastoModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.TipoGastoModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('tipogastos.index') );
        },
        idAttribute: 'id',
        defaults: {
            'tipogasto_nombre': '',
            'tipogasto_activo': 1,
            'plancuentas_nombre': ''
        }
    });

})(this, this.document);
