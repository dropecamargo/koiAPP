/**
* Class Nota2Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {
    app.Nota2Model = Backbone.Model.extend({
        urlRoot: function () {
            return window.Misc.urlFull( Route.route('notas.detalle.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'nota2_nota1': '',	
        	'nota2_documentos_doc': '',	
        	'nota2_id_doc': '',
        	'nota2_valor': ''
        }
    });
})(this, this.document);