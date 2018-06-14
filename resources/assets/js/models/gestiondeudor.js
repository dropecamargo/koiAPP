/**
* Class GestionDeudorModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.GestionDeudorModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('gestiondeudores.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'gestiondeudor_proxima': moment().format('YYYY-MM-DD'),
            'gestiondeudor_fh': moment().format('YYYY-MM-DD'),
        }
    });

})(this, this.document);
