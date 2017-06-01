/**
* Class visitap of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.VisitapCollection = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('ordenes.visitasp.index') );
        },
        model: app.VisitapModel,

        /**
        * Constructor Method
        */
        initialize : function(){
        }
   });
})(this, this.document);

