/**
* Class ImpuestoModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ImpuestoModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('impuestos.index') );
        },
        idAttribute: 'id',
        defaults: {
            'impuesto_nombre': '',
            'impuesto_porcentaje': '',
            'impuesto_activo': 1,
            'plancuentas_nombre': ''
        }
    });

})(this, this.document);
