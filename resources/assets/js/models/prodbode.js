/**
* Class ProdbodeModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ProdbodeModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('productos.prodbode.index') );
        },
        idAttribute: 'id',
        defaults: {
            'prodbode_serie': '',
            'prodbode_sucursal': '',
            'prodbode_cantidad': '',
            'prodbode_cantidadA': '',
            'prodbode_cantidadB': '',
            'prodbode_cantidadC': '',
            'prodbode_reservado': '',
            'prodbode_ubicacion1': '',
            'prodbode_ubicacion2': '',
            'prodbode_ubicacion3': '',
            'prodbode_maximo': '',
            'prodbode_minimo': ''
        }
    });
})(this, this.document);