/**
* Class FacturapModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.FacturapModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('facturasp.index') );
        },
        idAttribute: 'id',
        defaults: {
            'facturap1_regional': '',
            'facturap1_numero': '',
            'facturap1_fecha': moment().format('YYYY-MM-DD'),
            'facturap1_vencimiento': moment().format('YYYY-MM-DD'),
            'facturap1_primerpago': moment().format('YYYY-MM-DD'),
            'facturap1_cuotas':0,
            'facturap1_subtotal':'',
            'facturap1_descuento':'',
            'facturap1_factura': '',
            'facturap1_observaciones': '',
            'facturap1_tipogasto': '',
            'facturap1_tipoproveedor': '',
            'tercero_nit': '',
            'tercero_nombre': '',
            'tercero_persona':''

        }
    });

})(this, this.document);
