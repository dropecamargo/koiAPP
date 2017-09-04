/**
* Class RemRepuCollection of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.RemRepuCollection = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('ordenes.detalle.remrepuestos.index') );
        },
        model: app.RemRepu2Model,

        /**
        * Constructor Method
        */
        initialize : function(){
        },

        /**
        *setter remrepu_subtotal and iva_valor the model
        */
        setterSubtotal: function(model){
            var iva = model.get('remrepu2_iva_porcentaje')  / 100;
                descuento = (parseFloat(model.get('remrepu2_descuento_valor'))) * parseFloat(model.get('remrepu2_cantidad') ) ;
                costo = (parseFloat(model.get('remrepu2_costo'))) * parseFloat(model.get('remrepu2_cantidad'));
                ivaValor = (costo-descuento) * iva ;
            model.set('remrepu2_iva_valor', ivaValor);
            model.set('remrepu2_subtotal', (costo - descuento) + model.get('remrepu2_iva_valor'));
            
            // setter precio view table
            (parseFloat(model.get('remrepu2_precio_venta')) > 0) ? model.set('remrepu2_costo', model.get('remrepu2_precio_venta') ) : '';
            (parseFloat(model.get('remrepu2_precio_venta')) > 0) ? model.set('remrepu2_descuento_valor', descuento ) : '';
        },
   });
})(this, this.document);

