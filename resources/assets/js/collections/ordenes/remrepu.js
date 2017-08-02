/**
* Class RemRepuCollection of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.RemRepuCollection = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('ordenes.detalle.remrepuestos.index') );
        },
        model: app.RemRepu2Model,

        /**
        * Constructor Method
        */
        initialize : function(){
        },
   });
})(this, this.document);

