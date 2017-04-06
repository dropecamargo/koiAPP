/**
* Class MarcaModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.RegionalModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('regionales.index') );
        },
        idAttribute: 'id',
        defaults: {
            'regional_nombre': '',
            'regional_activo': 1
        }
    });

})(this, this.document);
