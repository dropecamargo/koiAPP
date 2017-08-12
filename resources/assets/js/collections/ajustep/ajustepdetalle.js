/**
* Class AjustepDetalleList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.AjustepDetalleList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('ajustesp.detalle.index') );
        },
        model: app.Ajustep2Model,

        /**
        * Constructor Method
        */
        initialize : function(){
        },

        validar: function(data){
            var error = { success: false };
            var model = _.find(this.models, function(item){
                if (item.has('facturap3_id') ) {
                    return item.get('facturap3_id') == data.facturap3_id;
                }
            });

            if(data.deleted){
                if ( model instanceof Backbone.Model ) {
                    model.view.remove();
                    this.remove(model);
                }
            }

            if(model instanceof Backbone.Model){
                model.set('facturap3_valor', data.facturap3_valor);
                model.set('ajustep2_valor', data.ajustep2_valor);
                model.set('ajustep2_naturaleza', data.ajustep2_naturaleza);
                model.set('valor', data.valor);
                return error;
            }

            error.success = true;
            return error;
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