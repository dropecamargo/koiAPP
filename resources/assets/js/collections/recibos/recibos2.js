/**
* Class DetalleReciboList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.DetalleReciboList = Backbone.Collection.extend({
        url: function() {
            return window.Misc.urlFull( Route.route('recibos.detalle.index') );
        },
        model: app.Recibo2Model,

        /**
        * Constructor Method
        */
        initialize : function(){
        },

        validar: function(data){
            var error = { success: false };

            var model = _.find(this.models, function(item){
                return item.get('recibo2_numero') == data.recibo2_numero;
            });

            if(data.deleted){
                if ( model instanceof Backbone.Model ) {
                    model.view.remove();
                    this.remove(model);
                }
            }

            if(model instanceof Backbone.Model){
                model.set('recibo2_valor', data.recibo2_valor);
                return error;
            }

            error.success = true;
            return error;
        },

        valor: function() {
            return this.reduce(function(sum, model) {
                return sum + parseFloat(model.get('recibo2_valor'))
            }, 0);
        },

        totalize: function() {
            var valor = this.valor();
            return { 'valor': valor }
        },

        validarC: function(data){
            var error = { success: false, valor: ''};

            var model = _.find(this.models, function(item){
                return item.get('recibo2_numero') == data;
            });

            if (model instanceof Backbone.Model ){
                error.success = true;
                error.valor = model.get('recibo2_valor');
            }

            return error;
        },
   });
})(this, this.document);