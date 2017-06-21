/**
* Class ConceptoCobModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ConceptoComModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('conceptoscomercial.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'conceptocom_nombre': '',
        	'conceptocom_activo': 1
        }
    });

})(this, this.document);
