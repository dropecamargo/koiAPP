/**
* Class TipoTrasladoModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.TipoTrasladoModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('tipostraslados.index') );
        },
        idAttribute: 'id',
        defaults: {
            'tipotraslado_nombre':'',
            'tipotraslado_sigla':'',
        	'tipotraslado_activo': 1
        }
    });

})(this, this.document);
