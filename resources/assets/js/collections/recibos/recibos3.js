/**
* Class DetalleRecibo3List of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.DetalleRecibo3List = Backbone.Collection.extend({
        url: function() {
            return window.Misc.urlFull( Route.route('recibos.mediopago.index') );
        },
        model: app.Recibo3Model,

        /**
        * Constructor Method
        */
        initialize : function(){
            
        },

        valor: function() {
            return this.reduce(function(sum, model) {
                return sum + parseFloat(model.get('recibo3_valor'));
            }, 0);
        },

        totalize: function() {
            var valor = this.valor();
            return { 'valor': valor }
        },
   });
})(this, this.document);