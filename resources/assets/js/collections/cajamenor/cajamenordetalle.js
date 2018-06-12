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

        total: function(){
            return this.reduce(function(sum, model) {
                return sum + (parseFloat(model.get('cajamenor2_valor')));
            }, 0);
        }
   });

})(this, this.document);
