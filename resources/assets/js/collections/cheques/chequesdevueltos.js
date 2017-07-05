/**
* Class ChDevueltoList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ChDevueltoList = Backbone.Collection.extend({
        url: function() {
            return window.Misc.urlFull( Route.route('chequesdevueltos.index') );
        },
        model: app.ChDevueltoModel,

        /**
        * Constructor Method
        */
        initialize : function(){
        
        },

        agregar: function(id,data){
            var model =  _.find(this.models, function(item){
                return item.get('id') == id;
            });
            // Preparo objeto
            modelo = {
                'recibo2_conceptosrc': data.recibo2_conceptosrc,
                'recibo2_naturaleza': 'C',
                'recibo2_chdevuelto': model.get('id'),
                'recibo2_valor': model.get('chdevuelto_valor'),
                'recibo2_numero': model.get('chdevuelto_numero'),
            }; 
            return modelo;
        },
   });
})(this, this.document);