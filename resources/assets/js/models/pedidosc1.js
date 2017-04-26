/**
* Class PedidoscModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.PedidoscModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('pedidosc.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'tercero_nombre': '',
        	'tercero_nit': '',
        	'contacto_nombre': '',
        	'pedidoc1_sucursal': '',
        	'pedidoc1_numero': '',
        	'pedidoc1_formapago': '',
        	'pedidoc1_contacto': '',
            'pedidoc1_tercero': '',
        	'pedidoc1_vendedor': '',
            'pedidoc1_primerpago': moment().format('YYYY-MM-DD'),
            'pedidoc1_fecha': moment().format('YYYY-MM-DD'),
        	'pedidoc1_observaciones': '',
        }
    });

})(this, this.document);
