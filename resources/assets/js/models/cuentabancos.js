/**
* Class CuentaBancoModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.CuentaBancoModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('cuentabancos.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'cuentabanco_nombre': '',
        	'cuentabanco_banco': '',
        	'cuentabanco_numero': '',
            'cuentabanco_cuenta': '',
        	'cuentabanco_activa': 1
        }
    });

})(this, this.document);
