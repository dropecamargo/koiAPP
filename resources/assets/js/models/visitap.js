/**
* Class VisitaModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

app || (app = {});

(function (window, document, undefined){

    app.VisitapModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull (Route.route('ordenes.visitasp.index') );
        },
        idAttribute: 'id',
        defaults: {
 			'visitap_orden': '',
            'visitap_cantidad': '',
 			'visitap_nombre': '',
 			'visitap_codigo': ''
        }
    });

}) (this, this.document);