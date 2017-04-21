/**
* Class SubCategoriaModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.SubCategoriaModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('subcategorias.index') );
        },
        idAttribute: 'id',
        defaults: {
            'subcategoria_nombre': '',
            'subcategoria_activo': 1,
            'subcategoria_margen_nivel1' : '',
            'subcategoria_margen_nivel2' : '',
            'subcategoria_margen_nivel3' : ''
        }
    });

})(this, this.document);
