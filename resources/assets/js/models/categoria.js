/**
* Class CategoriaModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.CategoriaModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('categorias.index') );
        },
        idAttribute: 'id',
        defaults: {
            'categoria_nombre': '',
            'categoria_activo': 1,
            'categoria_linea': ''
        }
    });

})(this, this.document);
