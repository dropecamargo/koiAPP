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
        }
        
   });
})(this, this.document);