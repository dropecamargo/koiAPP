/**
* Class DetalleFacturasp2Collection of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.DetalleFacturasp2Collection = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('facturasp.detalle.index') );
        },
        model: app.Facturap2Model,

        /**
        * Constructor Method
        */
        initialize : function(){
        },
   });

})(this, this.document);