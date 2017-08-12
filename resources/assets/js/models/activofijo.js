/**
* Class ActivoFijoModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ActivoFijoModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('activosfijos.index') );
        },
        idAttribute: 'id',
        defaults: {
            'activofijo_placa': '',
            'activofijo_serie': '',
            'activofijo_compra': '',
            'activofijo_activacion': '',
        }
    });

})(this, this.document);

