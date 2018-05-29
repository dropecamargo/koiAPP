/**
* Class CajaMenorDetalleList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.CajaMenorDetalleList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('cajasmenores.detalle.index') );
        },
        model: app.CajaMenor2Model,

        /**
        * Constructor Method
        */
        initialize : function(){
        },

        debito: function() {
            var debitos = _.filter(this.models, function(item){
                return item.get('ajustep2_naturaleza') == 'D';
            });
            return _.reduce(debitos, function(sum, model) {
                return sum + parseFloat( model.get('facturap3_valor') ? model.get('facturap3_valor') : model.get('ajustep2_valor'))
            }, 0);
        },

        credito: function() {
            var creditos = _.filter(this.models, function(item){
                return item.get('ajustep2_naturaleza') == 'C';
            });

            return _.reduce(creditos, function(sum, model) {
                return sum + parseFloat( model.get('facturap3_valor') ? model.get('facturap3_valor') : model.get('ajustep2_valor'))
            }, 0);
        },

        totalize: function() {
            var debito = this.debito();
            var credito = this.credito();
            return { 'debito': debito, 'credito': credito }
        },
   });

})(this, this.document);
