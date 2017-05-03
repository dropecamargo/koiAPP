/**
* Class DetallePedidoCollection of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.DetallePedidoCollection = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('pedidos.detalle.index') );
        },
        
        model: app.PedidoDetalleModel,

        /**
        * Constructor Method
        */
        initialize : function(){
        }
   });

})(this, this.document);