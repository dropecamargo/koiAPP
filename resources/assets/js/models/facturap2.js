/**
* Class Facturap2Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.Facturap2Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('facturasp.detalle.index') );
        },
        idAttribute: 'id',
        defaults: {
            'facturap2_impuesto': '',
            'facturap2_retefuente': '',
            'facurap2_base': '',
            'facturap2_porcentaje': ''
        }
    });

})(this, this.document);
