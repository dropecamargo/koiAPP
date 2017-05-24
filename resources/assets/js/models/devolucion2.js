/**
* Class Devolucion2Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.Devolucion2Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('devoluciones.detalle.index') );
        },
        idAttribute: 'id',
        defaults: {
            'devolucion2_cantidad' : 0,
            'devolucion2_precio' : '',
            'devolucion2_costo' : '',
        	'producto_serie' : '',
            'producto_nombre' : '',
            'devolucion2_total' : 0,
        	'factura2_cantidad' : 0,
        }
    });
})(this, this.document);