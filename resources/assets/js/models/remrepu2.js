/**
* Class RemRepu2Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

app || (app = {});

(function (window, document, undefined){

    app.RemRepu2Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull (Route.route('ordenes.detalle.remrepuestos.index') );
        },
        idAttribute: 'id',
        defaults: {
            'remrepu2_cantidad': '',
 			'remrepu2_nombre': '',
 			'remrepu2_serie': ''
        }
    });

}) (this, this.document);