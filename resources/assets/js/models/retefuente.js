/**
* Class ReteFuenteModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ReteFuenteModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('retefuentes.index') );
        },
        idAttribute: 'id',
        defaults: {
            'retefuente_nombre': '',
            'retefuente_base': 0,
            'retefuente_tarifa_declarante_natural': 0,
            'retefuente_tarifa_no_declarate_natural': 0,
            'retefuente_tarifa_juridico': 0,
            'retefuente_activo': 1,
        }
    });

})(this, this.document);
