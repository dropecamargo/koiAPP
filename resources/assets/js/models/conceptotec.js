/**
* Class ConceptoTecModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ConceptoTecModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('conceptostecnico.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'conceptotec_nombre': '',
        	'conceptotec_activo': 1
        }
    });

})(this, this.document);
