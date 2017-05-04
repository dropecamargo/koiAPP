/**
* Class PedidocDetalleCollection of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.PedidocDetalleCollection = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('pedidosc.detalle.index') );
        },
        model: app.PedidoscDetalleModel,

        /**
        * Constructor Method
        */
        initialize : function(){
        },

        validarExists : function(data){
            var error = { success: false};

            // Validate exist
            var modelExits = _.find(this.models, function(item) {
                return item.get('producto_serie') == data.producto_serie;
            });

            if(modelExits instanceof Backbone.Model ) {
                var cantidad = parseInt(modelExits.get('pedidoc2_cantidad')) + parseInt(data.pedidoc2_cantidad)
                //Setter del modelo
                modelExits.set('pedidoc2_cantidad', cantidad ) ;
                return error;
            }

            error.success = true;
            return error;
        },

        iva: function(){
            return this.reduce(function(sum, model) {
                var iva = model.get('pedidoc2_iva_porcentaje')  / 100;
                if (model.get('pedidoc2_precio_venta') > 0) {
                    return sum + parseFloat(model.get('pedidoc2_precio_venta')) * iva * parseFloat(model.get('pedidoc2_cantidad') ) 
                }else{
                    return sum + parseFloat(model.get('pedidoc2_costo')) * iva * parseFloat(model.get('pedidoc2_cantidad') ) 
                }
            }, 0);
        },
        descuento: function() {
            return this.reduce(function(sum, model) {
                return sum + (parseFloat(model.get('pedidoc2_descuento_valor'))) * parseFloat(model.get('pedidoc2_cantidad') ) 
            }, 0);
        },

        totalCosto: function() {
            return this.reduce(function(sum, model) {
                return sum + (parseFloat(model.get('pedidoc2_costo'))) * parseFloat(model.get('pedidoc2_cantidad')) 
            }, 0);
        },
        total: function(){
            return this.reduce(function(sum, model) {
                return sum + (parseFloat(model.get('pedidoc2_subtotal')));
            }, 0);
        },
        totalize: function() {
            var totalCosto = this.totalCosto();
                descuento = this.descuento();   
                iva = this.iva();
                total = this.total();
            return {'pedidoc1_bruto': totalCosto , 'pedidoc1_descuento': descuento, 'pedidoc1_iva': iva, 'pedidoc1_total': total}
        },
   });

})(this, this.document);