/**
* Class Recibo2Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {
    app.Recibo2Model = Backbone.Model.extend({
        urlRoot: function () {
            return window.Misc.urlFull( Route.route('recibos.detalle.index') );
        },
        idAttribute: 'id',
        defaults: {
            'recibo2_recibo1': '',  
        	'recibo2_numero': '',	
        	'recibo2_conceptosrc': '',	
        	'recibo2_documentos_doc': '',	
        	'recibo2_id_doc': '',	
        	'recibo2_naturaleza': '',	
            'recibo2_valor': '',
            'factura1_numero': '',
            'factura3_cuota': '',
            'factura3_valor': ''
        }
    });
})(this, this.document);