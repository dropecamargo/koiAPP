/**
* Class ReciboModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {
    app.ReciboModel = Backbone.Model.extend({
        urlRoot: function () {
            return window.Misc.urlFull( Route.route('recibos.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'recibo1_sucursal': '',	
        	'recibo1_numero': '',	
        	'recibo1_tercero': '',	
            'recibo1_fecha': moment().format('YYYY-MM-DD'),   
            'recibo1_fecha_pago': moment().format('YYYY-MM-DD'),   
        	'recibo1_valor': '',	
        	'recibo1_cuentas': '',	
            'recibo1_documentos': '',   
            'tercero_nit': '',   
        	'tercero_nombre': '',	
        	'recibo1_observaciones': ''
        }
    });
})(this, this.document);