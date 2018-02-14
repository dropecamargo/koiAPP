/**
* Class ConceptoAjustepModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ConceptoAjustepModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('conceptosajustep.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'conceptoajustep_nombre': '',
        	'plancuentas_cuenta': '',
            'plancuentas_nombre': '',
        	'conceptoajustep_sumas_iguales': 1,
        	'conceptoajustep_activo': 1
        }
    });

})(this, this.document);
