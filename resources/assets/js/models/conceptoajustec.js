/**
* Class ConceptoAjustecModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ConceptoAjustecModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('conceptosajustec.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'conceptoajustec_nombre': '',
            'conceptoajustec_plancuentas': '',
        	'plancuentas_cuenta': '',
            'plancuentas_nombre': '',
        	'conceptoajustec_sumas_iguales': 1,
        	'conceptoajustec_activo': 1
        }
    });

})(this, this.document);
