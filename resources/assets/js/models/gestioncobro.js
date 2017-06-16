/**
* Class GestionCobroModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.GestionCobroModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('gestioncobros.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'tercero_nit':'',
        	'tercero_nombre':'',
        	'gestioncobro_proxima': moment().format('YYYY-MM-DD'),
            'gestioncobro_fh': moment().format('YYYY-MM-DD'),
        	'gestioncobro_hproxima': moment().format('HH:mm'),
        }
    });

})(this, this.document);
