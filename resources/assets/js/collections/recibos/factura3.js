/**
* Class DetalleFacturaList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.DetalleFacturaList = Backbone.Collection.extend({
        url: function() {
            return window.Misc.urlFull( Route.route('recibos.factura.index') );
        },
        model: app.Factura3Model,

        /**
        * Constructor Method
        */
        initialize : function(){
        },

        agregar: function(id){
            // Setter value
            var model = _.find(this.models, function(item) {
                return item.get('id') == id;
            });

            if(model instanceof Backbone.Model ) {
                model.set('factura3_valor', model.get('factura3_saldo'));
            }
                
        },

        eliminar: function(id){
            // Remove value
            var model = _.find(this.models, function(item) {
                return item.get('id') == id;
            });
            
            if(model instanceof Backbone.Model ) {
                model.set('factura3_valor', 0);
            }
        }
   });
})(this, this.document);