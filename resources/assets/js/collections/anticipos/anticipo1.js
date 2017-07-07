/**
* Class AnticiposList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.AnticiposList = Backbone.Collection.extend({
        url: function() {
            return window.Misc.urlFull( Route.route('anticipos.index') );
        },
        model: app.AnticipoModel,

        /**
        * Constructor Method
        */
        initialize : function(){
            
        },
   });
})(this, this.document);