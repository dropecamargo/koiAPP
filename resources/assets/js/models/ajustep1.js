/**
* Class Ajustep1Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {
    app.Ajustep1Model = Backbone.Model.extend({
        urlRoot: function () {
            return window.Misc.urlFull( Route.route('ajustesp.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'ajustep1_regional': '',
        	'ajustep1_numero': '',	
        	'ajustep1_tercero': '',	
        	'ajustep1_conceptoajustec': '',	
        	'ajustep1_observaciones': '',
            'tercero_nit': '',   
        	'tercero_nombre': ''
        }
    });
})(this, this.document);