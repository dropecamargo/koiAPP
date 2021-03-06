/**
* Class PuntoVentaModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.PuntoVentaModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('puntosventa.index') );
        },
        idAttribute: 'id',
        defaults: {
            'puntoventa_nombre': '',
            'puntoventa_numero': 0,
            'puntoventa_prefijo': '',
            'puntoventa_resolucion_dian': '',
            'puntoventa_activo': 1,
            'puntoventa_observacion':'',
            'puntoventa_encabezado':'',
            'puntoventa_frase':'',
            'puntoventa_footer1': '',
            'puntoventa_footer2': '',
        }
    });

})(this, this.document);
