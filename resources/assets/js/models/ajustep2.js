/**
* Class Ajustep2Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.Ajustep2Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('ajustesp.detalle.index') );
        },
        idAttribute: 'id',
        defaults: {
            'ajustep2_tercero': '',
            'ajustep2_documentos_doc': '',
            'ajustep2_naturaleza': '',
            'facturap1_numero': '',
            'facturap3_cuota': '',
            'facturap3_valor': 0,
            'ajustep2_valor': 0,
        }
    });
})(this, this.document);