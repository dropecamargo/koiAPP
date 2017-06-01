/**
* Class SolicitanteModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.SolicitanteModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('solicitantes.index') );
        },
        idAttribute: 'id',
        defaults: {
            'solicitante_nombre': '',
            'solicitante_activo': true
        }
    });

})(this, this.document);
