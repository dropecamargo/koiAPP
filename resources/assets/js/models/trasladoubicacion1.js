/**
* Class TrasladoUbicacionModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.TrasladoUbicacionModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('trasladosubicaciones.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'trasladou1_sucursal': '',
        	'trasladou1_numero': '',
            'trasladou1_destino': '',
        	'trasladou1_origen': '',
            'trasladou1_tipotraslado':'',
        	'trasladou1_fecha': moment().format('YYYY-MM-DD'),
        	'trasladou1_observaciones': ''
		}
    });

})(this, this.document);