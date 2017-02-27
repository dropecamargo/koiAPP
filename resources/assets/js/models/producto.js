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
            'producto_codigo': '',
            'producto_codigoori': '',
            'producto_referencia': '',
            'producto_categoria': '',
            'producto_linea': '',
            'producto_marca': '',
            'producto_modelo': '',
            'producto_unidadmedida': '',
            'producto_peso': '',
            'producto_largo': '',
            'producto_alto': '',
            'producto_ancho': '',
            'producto_precio': 0,
            'producto_costo': 0,
            'producto_vidautil': 0,
            'producto_unidades': true,
            'producto_vence': true,
            'producto_serie': false,
            'producto_metrado': false
        }
    });

})(this, this.document);
