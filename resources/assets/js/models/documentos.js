/**
* Class DocumentosModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
* modelo de documentos admin
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.DocumentosModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('documento.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'documentos_codigo': '',
        	'documentos_nombre': '',
        	'documentos_cartera': 0,
        	'documentos_contabilidad': 0,
        	'documentos_comercial': 0,
        	'documentos_inventario': 0,
        	'documentos_tecnico': 0,
        	'documentos_tesoreria': 1
        }
    });

})(this, this.document);
