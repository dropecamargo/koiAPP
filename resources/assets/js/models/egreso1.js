/**
* Class Egreso1Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {
    app.Egreso1Model = Backbone.Model.extend({
        urlRoot: function () {
            return window.Misc.urlFull( Route.route('egresos.index') );
        },
        idAttribute: 'id',
        defaults: {
            'egreso1_fecha': moment().format('YYYY-MM-DD'),
            'egreso1_fecha_cheque': moment().format('YYYY-MM-DD'),
        }
    });
})(this, this.document);