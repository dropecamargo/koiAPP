/**
* Class DetalleFactura2Collection of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.DetalleFactura2Collection = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('facturas.detalle.index') );
        },
        model: app.Factura2Model,

        /**
        * Constructor Method
        */
        initialize : function(){
        },
        valid: function(){
            // var error = { success: false };

            // Validate exist
            _.each(this.models, function(item) {
                console.log(item);
                // (item.has('items')) ? error.success = true: error.success = false;
                // (item.get('maneja_serie') == 1) ? error.success = true: '';
            });
            // return error;
        },
        iva: function(){
            return this.reduce(function(sum, model) {
                var iva = model.get('factura2_iva_porcentaje')  / 100;
                if (model.get('factura2_precio_venta') > 0) {
                    return sum + parseFloat(model.get('factura2_precio_venta')) * iva * parseFloat(model.get('factura2_cantidad') )
                }else{
                    return sum + parseFloat(model.get('factura2_costo')) * iva * parseFloat(model.get('factura2_cantidad') )
                }
            }, 0);
        },
        descuento: function() {
            return this.reduce(function(sum, model) {
                return sum + (parseFloat(model.get('factura2_descuento_valor'))) * parseFloat(model.get('factura2_cantidad') )
            }, 0);
        },

        totalCosto: function() {
            return this.reduce(function(sum, model) {
                return sum + (parseFloat(model.get('factura2_costo'))) * parseFloat(model.get('factura2_cantidad'))
            }, 0);
        },
        total: function(){
            return this.reduce(function(sum, model) {
                return sum + (parseFloat(model.get('factura2_subtotal')));
            }, 0);
        },
        totalize: function() {
            var totalCosto = this.totalCosto();
                descuento = this.descuento();
                iva = this.iva();
                total = this.total();
            return {'factura1_bruto': totalCosto , 'factura1_descuento': descuento, 'factura1_iva': iva, 'factura1_total': total}
        },
   });

})(this, this.document);
