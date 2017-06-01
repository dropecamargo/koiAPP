/**
* Class visita of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.VisitaCollection = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('ordenes.visitas.index') );
        },
        model: app.VisitaModel,

        /**
        * Constructor Method
        */
        initialize : function(){
        }
   });
})(this, this.document);

