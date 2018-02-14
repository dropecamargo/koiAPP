/**
* Class TipoPagoModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.TipoPagoModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('tipopagos.index') );
        },
        idAttribute: 'id',
        defaults: {
            'tipopago_nombre': '',
            'tipopago_activo': 1,
            'tipopago_documentos': '',
            'plancuentas_nombre': ''
        }
    });

})(this, this.document);
