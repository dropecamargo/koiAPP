/**
* Class PedidoDetalleModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.PedidoDetalleModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('pedidos.detalle.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'pedido2_pedido1': '',	
        	'pedido2_serie': '',	
        	'pedido2_cantidad': '' ,	
        	'pedido2_saldo': '',	
        	'pedido2_precio': ''	
        	
        }
    });

})(this, this.document);
