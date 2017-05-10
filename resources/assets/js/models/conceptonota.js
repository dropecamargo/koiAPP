/**
* Class ConceptoNotaModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ConceptoNotaModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('conceptonotas.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'conceptonota_nombre': '',
        	'conceptonota_plancuentas': '',
            'plancuentas_cuenta': '',
            'plancuentas_nombre': '',
        	'conceptonota_activo': 1
        }
    });

})(this, this.document);
