/**
* Class DetalleChposFechadoList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.DetalleChposFechadoList = Backbone.Collection.extend({
        url: function() {
            return window.Misc.urlFull( Route.route('cheques.detalle.index') );
        },
        model: app.ChposFechado2Model,

        /**
        * Constructor Method
        */
        initialize : function(){
        
        },

        findModel: function(id){
            var modelo =  _.find(this.models, function(item){
                return item.get('id') == id;
            });
            return modelo;
        },
        validar: function(data){
            var error = { success: false };

            var model = _.find(this.models, function(item){
                return item.get('factura3_id') == data.factura3_id;
            });

            if(data.deleted){
                if ( model instanceof Backbone.Model ) {
                    model.view.remove();
                    this.remove(model);
                }
            }

            if(model instanceof Backbone.Model){
                model.set('factura3_valor', data.factura3_valor);
                return error;
            }

            error.success = true;
            return error;
        },

        valor: function() {
            return this.reduce(function(sum, model) {
                return sum + parseFloat( model.get('factura3_valor') ? model.get('factura3_valor') : model.get('chposfechado2_valor'))
            }, 0);
        },

        totalize: function() {
            var valor = this.valor();
            return { 'valor': valor }
        },
   });
})(this, this.document);