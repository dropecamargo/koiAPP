/**
* Class AjustecDetalleList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.AjustecDetalleList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('ajustesc.detalle.index') );
        },
        model: app.Ajustec2Model,

        /**
        * Constructor Method
        */
        initialize : function(){
        },

        validar: function(data){
            var error = { success: false };
            var model = _.find(this.models, function(item){
                if (item.has('factura3_id') ) {
                    return item.get('factura3_id') == data.factura3_id;

                }else if ( item.has('anticipo_id') ){
                    return item.get('anticipo_id') == data.anticipo_id;
                }else if ( item.has('chdevuelto_id') ){
                    return item.get('chdevuelto_id') == data.chdevuelto_id;
                }
            });

            if(data.deleted){
                if ( model instanceof Backbone.Model ) {
                    model.view.remove();
                    this.remove(model);
                }
            }

            if(model instanceof Backbone.Model){
                model.set('factura3_valor', data.factura3_valor);
                model.set('ajustec2_valor', data.ajustec2_valor);
                model.set('ajustec2_naturaleza', data.ajustec2_naturaleza);
                model.set('valor', data.valor);
                return error;
            }

            error.success = true;
            return error;
        },

        debito: function() {
            var debitos = _.filter(this.models, function(item){
                return item.get('ajustec2_naturaleza') == 'D';
            });
            return _.reduce(debitos, function(sum, model) {
                return sum + parseFloat( model.get('factura3_valor') ? model.get('factura3_valor') : model.get('ajustec2_valor'))
            }, 0);
        },

        credito: function() {
            var creditos = _.filter(this.models, function(item){
                return item.get('ajustec2_naturaleza') == 'C';
            });

            return _.reduce(creditos, function(sum, model) {
                return sum + parseFloat( model.get('factura3_valor') ? model.get('factura3_valor') : model.get('ajustec2_valor'))
            }, 0);
        },

        totalize: function() {
            var debito = this.debito();
            var credito = this.credito();
            return { 'debito': debito, 'credito': credito }
        },
   });

})(this, this.document);