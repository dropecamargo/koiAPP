/**
* Class TipoProductoModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.TipoProductoModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('tiposproducto.index') );
        },
       	idAttribute: 'id',
        defaults: {
            'tipoproducto_codigo': '',
            'tipoproducto_nombre': '',
            'tipoproducto_activo': 1
        }
    });

})(this, this.document);
