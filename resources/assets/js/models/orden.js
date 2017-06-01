/**
* Class OrdenModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

app || (app = {});

(function (window, document, undefined){

    app.OrdenModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull (Route.route('ordenes.index') );
        },
        idAttribute: 'id',
        defaults: {

            'orden_fecha': moment().format('YYYY-MM-DD'),
            'orden_tercero': '',
            'orden_tipoorden':'',
            'orden_solicitante':'',
            'orden_placa':'',
            'tercero_nombre':'',
            'tercero_nit':'',
            'tecnico_nombre':'',
            'tecnico_nit':'',
            'producto_id': '',
            'producto_serie':'',
            'producto_nombre':'',
            'orden_persona':'',
            'orden_dano':'',
            'orden_prioridad':'',
            'orden_problema': '',
            'orden_abierta': true,
            'orden_fecha_servicio':moment().format('YYYY-MM-DD'),
            'orden_hora_servicio':moment().format('HH:mm')          
        }
    });

}) (this, this.document);