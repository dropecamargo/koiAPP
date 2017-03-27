/**
* Class ProdBodeloteModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ProdBodeloteModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('productos.lotes.index') );
        },
        idAttribute: 'id',
        defaults: {

        }
    });

})(this, this.document);
