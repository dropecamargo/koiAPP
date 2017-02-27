/**
* Class ModeloModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ModeloModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('modelos.index') );
        },
       	idAttribute: 'id',
        defaults: {
            'modelo_nombre': '',
            'modelo_activo': true
        }
    });

})(this, this.document);