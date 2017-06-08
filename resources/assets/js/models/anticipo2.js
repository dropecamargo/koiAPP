/**
* Class Anticipo2Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {
    app.Anticipo2Model = Backbone.Model.extend({
        urlRoot: function () {
            return window.Misc.urlFull( Route.route('anticipos.mediopago.index') );
        },
        idAttribute: 'id',
        defaults: {
            'anticipo2_mediopago':'',
            'anticipo2_numero_medio':'',
            'anticipo2_vence_medio':'',
            'anticipo2_banco_medio':'',
            'anticipo2_valor': 0,
        }
    });
})(this, this.document);