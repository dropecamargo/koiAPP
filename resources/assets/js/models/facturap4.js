/**
* Class Facturap4Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.Facturap4Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('facturasp.valorescentroscostos.index') );
        },
        idAttribute: 'id',
        defaults: {
            'facturap4_valor': ''
        }
    });

})(this, this.document);
