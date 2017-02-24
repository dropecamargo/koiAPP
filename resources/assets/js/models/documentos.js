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
        	'documentos_nombre': ''
        }
    });

})(this, this.document);
