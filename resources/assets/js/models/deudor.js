/**
* Class DeudorModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.DeudorModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('deudores.index') );
        },
        idAttribute: 'id',
        defaults: {
        }
    });

})(this, this.document);
