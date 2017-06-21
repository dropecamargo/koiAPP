/**
* Class GestionComercialModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.GestionComercialModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('gestionescomercial.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'tercero_nit':'',
        	'tercero_nombre':'',
            'gestioncomercial_inicio': moment().format('YYYY-MM-DD'),
            'gestioncomercial_finalizo': moment().format('YYYY-MM-DD')
        }
    });

})(this, this.document);
