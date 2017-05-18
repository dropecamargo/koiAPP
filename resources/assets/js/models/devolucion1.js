/**
* Class DevolucionModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.DevolucionModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('devoluciones.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'devolucion1_sucursal' : '',
        	'devolucion1_numero' : '',
        	'devolucion1_fecha': moment().format('YYYY-MM-DD')
        }
    });
})(this, this.document);