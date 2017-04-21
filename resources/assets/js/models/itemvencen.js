/**
* Class ProductVencenModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ProductVencenModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('productos.vencen.index') );
        },
        idAttribute: 'id',
        defaults: {
            'prodbodevence_lote': '',
            'prodbodevence_unidades': 0,
            'prodbodevence_fecha': moment().format('YYYY-MM-DD')
        }
    });

})(this, this.document);
