/**
* Class Anticipo3Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {
    app.Anticipo3Model = Backbone.Model.extend({
        urlRoot: function () {
            return window.Misc.urlFull( Route.route('anticipos.detalle.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'anticipo3_anticipo1': '',	
        	'anticipo3_conceptosrc': '',	
        	'anticipo3_naturaleza': '',	
            'anticipo3_valor': ''
        }
    });
})(this, this.document);