/**
* Class Pedidosc1DetalleModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.Pedidosc1DetalleModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('ajustes.detalle.index') );
        },
        idAttribute: 'id',
        defaults: {	
            
        }
    });

})(this, this.document);
