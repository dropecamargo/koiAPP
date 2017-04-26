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
            'pedidoc2_cantidad' : '',
            'pedidoc2_precio_venta' : '',
            'pedidoc2_descuento_valor': '',
            'pedidoc2_descuento_porcentaje': '',
            'pedidoc2_iva_porcentaje': ''
        }
    });

})(this, this.document);
