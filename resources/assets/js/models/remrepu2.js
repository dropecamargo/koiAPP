/**
* Class RemRepu2Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

app || (app = {});

(function (window, document, undefined){

    app.RemRepu2Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull (Route.route('ordenes.detalle.remrepuestos.index') );
        },
        idAttribute: 'id',
        defaults: {
            'remrepu2_cantidad': '',
 			'remrepu2_nombre': '',
 			'remrepu2_serie': '',
            'remrepu2_facturado': '',
 			'remrepu2_facturado_tec': '',
 			'remrepu2_no_facturado': '',
 			'remrepu2_saldo': '',
 			'remrepu2_devuelto': '',
 			'remrepu2_usado': '',
            'remrepu2_precio_venta' : 0,
            'remrepu2_descuento_valor': 0,
            'remrepu2_descuento_porcentaje': 0,
            'remrepu2_iva_porcentaje': 0,
            'remrepu2_costo': 0,
            'remrepu2_subtotal': 0,
            'remrepu2_iva_valor':0,
 			'remrepu1_numero': '',
 			'remrepu1_tipo': '',
 			'sucursal_nombre': ''
        }
    });

}) (this, this.document);