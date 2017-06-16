/**
* Class CarteraTerceroModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.CarteraTerceroModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('carteraterceros.index') );
        },
        idAttribute: 'id',
        defaults: {
            'factura3_factura1': '',
            'factura3_cuota': '',
            'factura3_valor': '',
            'factura3_saldo': '',
            'factura3_vencimiento': '',
        }
    });

})(this, this.document);