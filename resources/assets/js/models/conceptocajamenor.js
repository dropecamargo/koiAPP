/**
* Class ConceptoCajaMenorModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ConceptoCajaMenorModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('conceptoscajamenor.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'conceptocajamenor_nombre': '',
            'conceptocajamenor_ventas': '',
            'conceptocajamenor_administrativo': '',
            'conceptocajamenor_activo': 1,
        	// 'plancuentas_cuenta': '',
            // 'plancuentas_nombre': '',
        }
    });

})(this, this.document);
