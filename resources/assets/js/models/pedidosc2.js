/**
* Class PedidoscDetalleModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.PedidoscDetalleModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('pedidosc.detalle.index') );
        },
        idAttribute: 'id',
        defaults: {	
            'pedidoc2_cantidad' : 0,
            'pedidoc2_precio_venta' : 0,
            'pedidoc2_descuento_valor': 0,
            'pedidoc2_descuento_porcentaje': 0,
            'pedidoc2_iva_porcentaje': 0,
            'pedidoc2_costo': 0,
            'pedidoc2_subtotal': 0,
            'pedidoc2_iva_valor':0,
            'pedidoc2_margen_porcentaje': 0, 
        }
    });

})(this, this.document);
