/**
* Class VisitaModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

app || (app = {});

(function (window, document, undefined){

    app.VisitaModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull (Route.route('ordenes.visitas.index') );
        },
        idAttribute: 'id',

        defaults: {
            'visita_orden': '',
            'visita_tecnico': '',
            'visita_numero': '',
            'visita_fecha_llegada': moment().format('YYYY-MM-DD'),
            'visita_fecha_inicio': moment().format('YYYY-MM-DD'),
            'visita_fecha_fin': moment().format('YYYY-MM-DD'),
            'visita_fh_finaliza': '',
            'visita_tiempo_transporte': '',
            'visita_viaticos': '',
            'visita_observaciones': '',
            'tercero_nombre': ''
        }
    });

}) (this, this.document);