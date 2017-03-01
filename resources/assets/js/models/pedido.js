/**
* Class PedidoModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.PedidoModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('pedidos.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'pedido1_numero': '',	
        	'pedido1_tercero': '',	
        	'pedido1_documentos': '' ,	
        	'pedido1_sucursal': '',	
        	'pedido1_anticipo': '',	
        	'pedido1_observaciones': '',	
        	'pedido1_anulado': false,	
        	'pedido1_cerrado': false,	
        	'pedido1_fecha': moment().format('YYYY-MM-DD'),	
        	'pedido1_fecha_estimada': moment().format('YYYY-MM-DD'),	
        	'pedido1_fecha_anticipo': moment().format('YYYY-MM-DD'),
            'tercero_nombre':'',
            'tercero_nit':''
        }
    });

})(this, this.document);
