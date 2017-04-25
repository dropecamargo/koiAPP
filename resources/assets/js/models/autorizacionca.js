/**
* Class AutorizacionCaModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.AutorizacionCaModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('autorizacionesca.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'tercero_nit': '',
        	'tercero_nombre': '',
        	'autorizaca_vencimiento': moment().format('YYYY-MM-DD'),
        	'autorizaca_plazo': 1,
        	'autorizaca_cupo': 1,
        	'autorizaca_observaciones': '',
        }
    });

})(this, this.document);
