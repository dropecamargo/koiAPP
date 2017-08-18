/**
* Class DetalleEgresoList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.DetalleEgresoList = Backbone.Collection.extend({
        url: function() {
            return window.Misc.urlFull( Route.route('egresos.detalle.index') );
        },
        model: app.Egreso2Model,

        /**
        * Constructor Method
        */
        initialize : function(){
        },

        validar: function(data){
            var error = { success: false };
            var model = _.find(this.models, function(item){
                if (item.has('facturap2_id') ) {
                    return item.get('facturap2_id') == data.facturap2_id;
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
                model.set('egreso2_valor', data.egreso2_valor);
                model.set('valor', data.valor);
                return error;
            }

            error.success = true;
            return error;
        },

        valor: function() {
            return this.reduce(function(sum, model) {
                return sum + parseFloat( model.get('facturap3_valor') ? model.get('facturap3_valor') : model.get('egreso2_valor'))
            }, 0);
        },

        totalize: function() {
            var valor = this.valor();
            return { 'valor': valor }
        },
   });
})(this, this.document);