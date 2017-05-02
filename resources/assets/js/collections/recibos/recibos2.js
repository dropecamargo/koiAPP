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
        }
        
   });
})(this, this.document);