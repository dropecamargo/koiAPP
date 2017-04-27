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

        cantidad: function() {
            return this.reduce(function(sum, model) {
                return sum + parseFloat(model.get('pedidoc2_cantidad')) 
            }, 0);
        },

        subtotal: function() {
            return this.reduce(function(sum, model) {
                return sum + parseFloat(model.get('pedidoc2_precio_venta'))
            }, 0);
        },

        totalize: function() {
            var cantidad = this.cantidad();
            var subtotal = this.subtotal();
            return { 'cantidad': cantidad, 'subtotal': subtotal}
        },
   });

})(this, this.document);