/**
* Class RemRepuModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

app || (app = {});

(function (window, document, undefined){

    app.RemRepuModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull (Route.route('ordenes.remrepuestos.index') );
        },
        idAttribute: 'id',
        defaults: {
            'remrepu_cantidad': '',
 			'remrepu_nombre': '',
 			'remrepu_serie': ''
        }
    });

}) (this, this.document);