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
        }
   });

})(this, this.document);
