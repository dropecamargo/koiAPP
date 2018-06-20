/**
* Class LineaModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.LineaModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('lineas.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'linea_nombre' : '',
        	'linea_margen_nivel1' : 0,
        	'linea_margen_nivel2' : 0,
        	'linea_margen_nivel3' : 0,
            'linea_unidadnegocio' : '',
            'linea_inventario' : '',
            'linea_venta' : '',
            'linea_costo' : '',
            'linea_activo' : 1
        }
    });

})(this, this.document);
