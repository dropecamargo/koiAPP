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
                model.set('recibo2_valor', data.recibo2_valor);
                model.set('valor', data.valor);
                return error;
            }

            error.success = true;
            return error;
        },

        valor: function() {
            return this.reduce(function(sum, model) {
                return sum + parseFloat( model.get('factura3_valor') ? model.get('factura3_valor') : model.get('recibo2_valor'))
            }, 0);
        },

        totalize: function() {
            var valor = this.valor();
            return { 'valor': valor }
        },
   });
})(this, this.document);