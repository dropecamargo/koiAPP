/**
* Class TipoOrdenModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.TipoOrdenModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('tiposorden.index') );
        },
        idAttribute: 'id',
        defaults: {
            'tipoorden_nombre': '',
            'tipoorden_activo': true
        }
    });

})(this, this.document);
