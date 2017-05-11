/**
* Class Factura2Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.Factura2Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('facturas.detalle.index') );
        },
        idAttribute: 'id',
        defaults: {
            'factura2_cantidad' : 0,
            'factura2_precio_venta' : 0,
            'factura2_descuento_valor': 0,
            'factura2_descuento_porcentaje': 0,
            'factura2_iva_porcentaje': 0,
            'factura2_costo': 0,
            'factura2_subtotal': 0,
            'factura2_iva_valor':0,
            'pedido1_id': '',
        }
    });
})(this, this.document);