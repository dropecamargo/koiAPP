/**
* Class NotaModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {
    app.NotaModel = Backbone.Model.extend({
        urlRoot: function () {
            return window.Misc.urlFull( Route.route('notas.index') );
        },
        idAttribute: 'id',
        defaults: {
            'nota1_sucursal': '',   
        	'nota1_numero': '',	
        	'nota1_tercero': '',	
            'nota1_fecha': moment().format('YYYY-MM-DD'),   
        	'nota1_observaciones': '',
        	'nota1_conceptonota': '',	
            'tercero_nit': '',   
        	'tercero_nombre': ''
        }
    });
})(this, this.document);