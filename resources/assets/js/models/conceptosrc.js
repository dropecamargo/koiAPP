/**
* Class ConceptosrcModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ConceptosrcModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('conceptosrc.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'conceptosrc_nombre': '',
            'conceptosrc_documentos': '',
            'plancuentas_cuenta': '',
            'plancuentas_nombre': '',
        	'conceptosrc_activo': 1
        }
    });

})(this, this.document);
