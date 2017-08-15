/**
* Class ProductoLote of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ProductoLote = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('productos.lotes.index') );
        },
        model: app.LoteModel,

        /**
        * Constructor Method
        */
        initialize : function(){
        },
        /**
        * Valid entrada
        */
        validEntrada:function(uentrada){
            var data = {'success': true , 'unidades':0};  
            var unidades = 0;
            _.each(this.models, function(item){ 
                unidades+= parseFloat( $('#prodbodevence_unidades_'+item.get('id')).val());
            });
            if(unidades >= uentrada) {
                data.success =  ("No puede superar la cantidad de unidades(" + uentrada +") a ingresar, por favor verifique información.");
            }
            data.unidades = unidades
            return data;
        }
   });

})(this, this.document);
