/**
* Class DevolucionDetalleCollection of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.DevolucionDetalleCollection = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('devoluciones.detalle.index') );
        },
        model: app.Devolucion2Model,

        /**
        * Constructor Method
        */
        initialize : function(){
        },

        /**
        *
        */
        ValidCantidad:function(cant,id){
            var error = { success: false};
            var item = _.find(this.models,function(model){
                return model.get('id') == id;
            });
            if ( cant > item.get('devolucion2_cantidad')) {
                error.error = 'Cantidad a devolver no corresponde con las cantidades que fueron facturadas';
                return error;
            }
            var totalItem = cant * item.get('devolucion2_costo');
            item.set('devolucion2_devueltas', cant);
            item.set('devolucion2_total', totalItem);
            error.success = true;
            error.total = item.get('devolucion2_total');
            error.totales = this.totalize();
            return error;
        },
        descontadas:function(){
            return this.reduce(function(sum, model) {
                return sum + (parseFloat(model.get('devolucion2_devueltas'))) 
            }, 0);
        },
        totalBruto:function(){
            return this.reduce(function(sum, model) {
                return sum + (parseFloat(model.get('devolucion2_total'))) 
            }, 0);
        },
        iva:function(){
            return this.reduce(function(sum, model) {
                var iva = model.get('devolucion2_iva')  / 100;
                if (model.get('devolucion2_precio') > 0) {
                    return sum + parseFloat(model.get('devolucion2_precio')) * iva * parseFloat(model.get('devolucion2_devueltas') ) 
                }else{
                    return sum + parseFloat(model.get('devolucion2_costo')) * iva * parseFloat(model.get('devolucion2_devueltas') ) 
                }
            }, 0);
        },
        descuento:function(){
            return this.reduce(function(sum, model) {
                return sum + (parseFloat(model.get('devolucion2_descuento'))) * parseFloat(model.get('devolucion2_devueltas') ) 
            }, 0);
        },
        totalize:function(){
            var totalBruto = this.totalBruto();
                descontadas = this.descontadas();   
                iva = this.iva();   
                descuento = this.descuento();   
                total = (totalBruto + iva) - descuento;
            return {'devolucion1_bruto': totalBruto , 'devueltasTotal': descontadas, 'devolucion1_iva': iva, 'devolucion1_descuento':descuento,'devolucion1_total':total }
        },
   });

})(this, this.document);