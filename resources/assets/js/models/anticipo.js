/**
* Class AnticipoModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.AnticipoModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('anticipos.index') );
        },
        idAttribute: 'id',
        defaults: {
			'anticipo1_fecha':moment().format('YYYY-MM-DD'),
			'anticipo1_sucursal':'',
			'anticipo1_numero':'',
			'anticipo1_tercero':'',
			'anticipo1_cuentas':'',
			'tercero_nit':'',
			'tercero_nombre':'',
			'anticipo1_vendedor':'',
			'anticipo1_observacion':'',
        }
    });

})(this, this.document);
