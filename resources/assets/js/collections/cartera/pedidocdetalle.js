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
        model: app.Pedidosc1DetalleModel,

        /**
        * Constructor Method
        */
        initialize : function(){
        }
   });

})(this, this.document);