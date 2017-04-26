/**
* Class BancoModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.BancoModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('bancos.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'banco_nombre': '',
        	'banco_activo': 1
        }
    });

})(this, this.document);
