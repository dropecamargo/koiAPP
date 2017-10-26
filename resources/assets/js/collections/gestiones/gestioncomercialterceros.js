/**
* Class GestionComercialCollection of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.GestionComercialCollection = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('gestionescomercial.index') );
        },
        model: app.GestionComercialModel,

        /**
        * Constructor Method
        */
        initialize : function(){
        }
   });

})(this, this.document);