/**
* Class ChequeModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ChequeModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('cheques.index') );
        },
        idAttribute: 'id',
        defaults: {
			'chposfechado1_fecha':moment().format('YYYY-MM-DD'),
			'chposfechado1_ch_fecha':moment().format('YYYY-MM-DD'),
			'chposfechado1_sucursal':'',
			'chposfechado1_numero':'',
			'chposfechado1_tercero':'',
			'chposfechado1_valor': 0,
			'chposfechado1_observaciones':'',
			'tercero_nit':'',
			'tercero_nombre':'',
        }
    });

})(this, this.document);
