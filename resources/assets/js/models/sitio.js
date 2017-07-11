/**
* Class SitioModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.SitioModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('sitios.index') );
        },
        idAttribute: 'id',
        defaults: {
            'sitio_nombre': '',
            'sitio_activo': 1,
        }
    });

})(this, this.document);
