/**
* Class FacturaModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.FacturaModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('facturas.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'factura1_sucursal' : '',
        	'factura1_puntoventa' : '',
        	'factura1_numero' : '',
        	'factura1_fecha': moment().format('YYYY-MM-DD'),
        	'tercero_nit':'',
        	'tercero_nombre': '',
        	'factura1_tercerocontacto': '',
        	'contacto_nombre':'',
        	'factura1_formapago':'',
        	'factura1_primerpago': moment().format('YYYY-MM-DD'),
        	'factura1_vendedor':'',
        	'factura1_observaciones': ''
        }
    });
})(this, this.document);