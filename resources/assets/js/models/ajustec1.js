/**
* Class Ajustec1Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {
    app.Ajustec1Model = Backbone.Model.extend({
        urlRoot: function () {
            return window.Misc.urlFull( Route.route('ajustesc.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'ajustec1_sucursal': '',
        	'ajustec1_numero': '',	
        	'ajustec1_tercero': '',	
        	'ajustec1_conceptoajustec': '',	
        	'ajustec1_observaciones': '',
            'tercero_nit': '',   
        	'tercero_nombre': ''
        }
    });
})(this, this.document);