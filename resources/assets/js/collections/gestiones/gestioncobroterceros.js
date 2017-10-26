/**
* Class GestionCobrosCollection of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.GestionCobrosCollection = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('gestioncobros.index') );
        },
        model: app.GestionCobroModel,

        /**
        * Constructor Method
        */
        initialize : function(){
        }
   });

})(this, this.document);