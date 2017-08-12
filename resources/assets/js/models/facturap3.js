/**
* Class Facturap3Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.Facturap3Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('facurasp.cuotas.index') );
        },
        idAttribute: 'id',
        defaults: {
            'facturap3_facturap1': '',
            'facturap3_cuota': '',
            'facturap3_valor': '',
            'facturap3_saldo': '',
            'facturap3_vencimiento': '',
        }
    });

})(this, this.document);