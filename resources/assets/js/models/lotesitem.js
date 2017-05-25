/**
* Class ItemLoteModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.LoteModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('productos.lotes.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'lote_numero': '',
        	'lote_cantidad': 0,
        	'lote_saldo': '',
        	'lote_fecha': moment().format('YYYY-MM-DD'),
        	'lote_vencimiento': moment().format('YYYY-MM-DD'),
        }
    });

})(this, this.document);
