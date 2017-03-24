/**
* Class UnidadNegocioModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.UnidadNegocioModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('unidadesnegocio.index') );
        },
        idAttribute: 'id',
        defaults: {
            'unidadnegocio_nombre': '',
        	'unidadnegocio_activo': false
        }
    });

})(this, this.document);
