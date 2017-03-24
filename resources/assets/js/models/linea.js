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
        	'linea_activo' : true,
        	'linea_margen_nivel1' : '',
        	'linea_margen_nivel2' : '',
        	'linea_margen_nivel3' : ''
        }
    });

})(this, this.document);
