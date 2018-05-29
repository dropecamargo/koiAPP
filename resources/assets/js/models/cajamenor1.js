/**
* Class CajaMenor1Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {
    app.CajaMenor1Model = Backbone.Model.extend({
        urlRoot: function () {
            return window.Misc.urlFull( Route.route('cajasmenores.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'cajamenor1_regional': '',
        	'cajamenor1_numero': '',
        	'cajamenor1_tercero': '',
        	'cajamenor1_fecha': '',
        	'cajamenor1_observaciones': ''
        }
    });
})(this, this.document);
