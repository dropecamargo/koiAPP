/**
* Class ProductoModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ProductoModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('productos.index') );
        },
        idAttribute: 'id',
        defaults: {
            'producto_nombre': '',
            'producto_referencia': '',
            'producto_ref_proveedor': '',
            'producto_grupo': '',
            'producto_barras': '',
            'producto_serie': '',
            'producto_linea': '',
            'producto_marca': '',
            'producto_modelo': '',
            'producto_impuesto': '',
            'producto_unidadmedida': '',
            'producto_peso': '0',
            'producto_largo': '0',
            'producto_alto': '0',
            'producto_ancho': '0',
            'producto_precio1': 0,
            'producto_precio2': 0,
            'producto_precio3': 0,
            'producto_costo': 0,
            'producto_vidautil': 0,
            'producto_vence': 0,
            'producto_maneja_serie': 0,
            'producto_metrado': 0,
            'producto_tipoproducto':'',
            'producto_subgrupo':'',
            'producto_contacto':'',
            'producto_tercero':'',
            'producto_servicio':'',
            'producto_vencimiento': moment().format('YYYY-MM-DD'),
            'producto_unidad': 1,
            'modelo_nombre': ''
        }
    });
})(this, this.document);
