/**
* Class ProductoVenceList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ProductoVenceList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('productos.vencen.index') );
        },
        model: app.ProductVencenModel,

        /**
        * Constructor Method
        */
        initialize : function(){
        }
   });

})(this, this.document);
