/**
* Class ChDevueltoModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ChDevueltoModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('chequesdevueltos.index') );
        },
        idAttribute: 'id',
        defaults: {
			'tercero_nit':'',
			'tercero_nombre':'',
        }
    });

})(this, this.document);
