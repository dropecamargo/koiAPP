/**
* Class ActivoFijoList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ActivoFijoList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('activosfijos.index') );
        },
        model: app.ActivoFijoModel,

        /**
        * Constructor Method
        */
        initialize : function(){
        },
   });

})(this, this.document);