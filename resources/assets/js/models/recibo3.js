/**
* Class Recibo3Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {
    app.Recibo3Model = Backbone.Model.extend({
        urlRoot: function () {
            return window.Misc.urlFull( Route.route('recibos.mediopago.index') );
        },
        idAttribute: 'id',
        defaults: {
            'recibo3_mediopago':'',
            'recibo3_numero_medio':'',
            'recibo3_vence_medio':'',
            'recibo3_banco_medio':'',
            'recibo3_valor':'',
        }
    });
})(this, this.document);