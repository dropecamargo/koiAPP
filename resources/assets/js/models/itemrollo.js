/**
* Class ItemRolloModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ItemRolloModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('productos.rollos.index') );
        },
        idAttribute: 'id',
        defaults: {
            'rollo_metros': 0,
        	'rollo_cantidad': 0, //cantidad input form modal 
            'rollo_saldo': 0,
            'rollo_lote': '',
        	'rollo_fecha_lote': ''
        }
    });

})(this, this.document);
