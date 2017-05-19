/**
* Class Ajustec2Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.Ajustec2Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('ajustesc.detalle.index') );
        },
        idAttribute: 'id',
        defaults: {
            'ajustec2_tercero': '',
            'ajustec2_documentos_doc': '',
            'ajustec2_naturaleza': '',
            'factura1_numero': '',
            'factura3_cuota': '',
            'factura3_valor': 0,
            'ajustec2_valor': 0,
        }
    });
})(this, this.document);