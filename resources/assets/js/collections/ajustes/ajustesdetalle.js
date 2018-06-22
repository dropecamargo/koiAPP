/**
* Class AjustesDetalleCollection of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.AjustesDetalleCollection = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('ajustes.detalle.index') );
        },
        model: app.AjusteDetalleModel,

        /**
        * Constructor Method
        */
        initialize : function(){
        },

        diferencia: function(){
            return this.entrada() - this.salida();
        },

        entrada: function(){
            var entradas = _.filter(this.models, function(item){
                return item.get('ajuste2_cantidad_entrada') > 0;
            });

            return _.reduce(entradas, function(sum, model) {
                return sum + parseFloat( model.get('ajuste2_costo') )
            }, 0);
        },

        salida: function(){
            var salidas = _.filter(this.models, function(item){
                return item.get('ajuste2_cantidad_salida') > 0;
            });

            return _.reduce(salidas, function(sum, model) {
                return sum + parseFloat( model.get('ajuste2_costo') )
            }, 0);
        },

        total: function(){
            return this.entrada() + this.salida();
        }
   });

})(this, this.document);
