/**
* Class CajaMenor2Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.CajaMenor2Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('cajasmenores.detalle.index') );
        },
        idAttribute: 'id',
        defaults: {
            'cajamenor2_tercero': '',
            'cajamenor2_valor': 0,
        }
    });
})(this, this.document);
