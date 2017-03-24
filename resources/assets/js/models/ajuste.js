/**
* Class AjusteModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.AjusteModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('ajustes.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'ajuste1_numero': '',	
        	'ajuste1_documentos': '' ,	
            'ajuste1_sucursal': '',
            'ajuste1_tipoajuste': '',
            'ajuste1_fecha': '',
        	'ajuste1_observaciones': ''
        }
    });

})(this, this.document);
