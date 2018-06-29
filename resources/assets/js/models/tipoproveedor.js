/**
* Class TipoProveedorModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.TipoProveedorModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('tipoproveedores.index') );
        },
        idAttribute: 'id',
        defaults: {
            'tipoproveedor_nombre': '',
            'tipoproveedor_activo': 1,
            'tipoproveedor_cuenta': '',
            'plancuentas_nombre': ''
        }
    });

})(this, this.document);
