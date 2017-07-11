/**
* Class ServicioModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ServicioModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('servicios.index') );
        },
        idAttribute: 'id',
        defaults: {
            'servicio_nombre': '',
            'servicio_activo': 1,
        }
    });

})(this, this.document);
