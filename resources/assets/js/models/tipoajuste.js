/**
* Class TipoAjusteModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.TipoAjusteModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('tiposajuste.index') );
        },
        idAttribute: 'id',
        defaults: {
            'tipoajuste_nombre':'',
            'tipoajuste_sigla':'',
            'tipoajuste_tipo':'',
            'tipoajuste_tipoproducto':'',
        	'tipoajuste_cuenta': '',
        	'tipoajuste_calculaiva': 0,
        	'tipoajuste_activo': 1
        }
    });

})(this, this.document);
