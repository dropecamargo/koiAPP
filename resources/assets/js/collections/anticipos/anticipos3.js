/**
* Class DetalleAnticipo3List of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.DetalleAnticipo3List = Backbone.Collection.extend({
        url: function() {
            return window.Misc.urlFull( Route.route('anticipos.detalle.index') );
        },
        model: app.Anticipo3Model,

        /**
        * Constructor Method
        */
        initialize : function(){
        },
        valor: function() {
            return this.reduce(function(sum, model) {
                return sum + parseFloat(model.get('anticipo3_valor'));
            }, 0);
        },

        totalize: function() {
            var valor = this.valor();
            return { 'valor': valor }
        },
   });
})(this, this.document);