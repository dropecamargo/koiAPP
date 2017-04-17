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
            'producto_categoria': '',
            'producto_barras': '',
            'producto_serie': '',
            'producto_linea': '',
            'producto_marca': '',
            'producto_modelo': '',
            'producto_impuesto': '',
            'producto_unidadmedida': '',
            'producto_peso': '',
            'producto_largo': '',
            'producto_alto': '',
            'producto_ancho': '',
            'producto_precio1': 0,
            'producto_precio2': 0,
            'producto_precio3': 0,
            'producto_costo': 0,
            'producto_vidautil': 0,
            'producto_vence': 0,
            'producto_maneja_serie': 1,
            'producto_metrado': 0,
            'producto_unidadnegocio':'',
            'producto_subcategoria':'', 
            'producto_unidad': 1
        }
    });
})(this, this.document);