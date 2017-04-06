/**
* Class SucursalModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.SucursalModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('sucursales.index') );
        },
        idAttribute: 'id',
        defaults: {
            'sucursal_nombre': '',
            'sucursal_direccion': '',
            'sucursal_direccion_nomenclatura': '',
            'sucursal_regional': '',
            'sucursal_telefono': '',
        	'sucursal_activo': 1
        }
    });

})(this, this.document);
