/**
* Class ConceptoCobModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ConceptoCobModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('conceptocobros.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'conceptocob_nombre': '',
        	'conceptocob_activo': 1
        }
    });

})(this, this.document);
