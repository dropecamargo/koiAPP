/**
* Class DanoModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.DanoModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('danos.index') );
        },
        idAttribute: 'id',
        defaults: {
            'dano_nombre': '',
            'dano_activo': true
        }
    });

})(this, this.document);
