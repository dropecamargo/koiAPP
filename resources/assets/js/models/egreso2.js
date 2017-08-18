/**
* Class Egreso2Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {
    app.Egreso2Model = Backbone.Model.extend({
        urlRoot: function () {
            return window.Misc.urlFull( Route.route('egresos.detalle.index') );
        },
        idAttribute: 'id',
        defaults: {
            'egreso2_egreso1': '',  
        	'egreso2_numero': '',	
        	'egreso2_documentos_doc': '',	
        	'egreso2_id_doc': '',	
            'egreso2_valor': '',
            'facturap1_numero': '',
            'facturap3_cuota': '',
            'facturap3_valor': ''
        }
    });
})(this, this.document);