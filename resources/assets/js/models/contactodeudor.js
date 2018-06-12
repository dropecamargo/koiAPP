/**
* Class ContactoDeudorModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ContactoDeudorModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('deudores.contactos.index') );
        },
        idAttribute: 'id',
        defaults: {
        }
    });

})(this, this.document);
