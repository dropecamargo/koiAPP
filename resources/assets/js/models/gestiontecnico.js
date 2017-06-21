/**
* Class GestionTecnicoModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.GestionTecnicoModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('gestionestecnico.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'tercero_nit':'',
        	'tercero_nombre':'',
            'gestiontecnico_inicio': moment().format('YYYY-MM-DD'),
            'gestiontecnico_finalizo': moment().format('YYYY-MM-DD')
        }
    });

})(this, this.document);
