/**
* Class CausaModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.CausaModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('causas.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'causal_nombre': '',
        	'causal_activo': 1
        }
    });

})(this, this.document);
