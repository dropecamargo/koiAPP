/**
* Class ChposFechado2Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {
    app.ChposFechado2Model = Backbone.Model.extend({
        urlRoot: function () {
            return window.Misc.urlFull( Route.route('cheques.detalle.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'chposfechado2_chposfechado1': '',	
        	'chposfechado2_conceptosrc': '',	
        	'chposfechado2_documentos_doc': '',	
        	'chposfechado2_id_doc': '',	
            'chposfechado2_valor': '',
            'factura1_numero': '',
            'factura3_cuota': '',
            'factura3_valor': ''
        }
    });
})(this, this.document);