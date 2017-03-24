/**
* Class AjusteDetalleModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.AjusteDetalleModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('ajustes.detalle.index') );
        },
        idAttribute: 'id',
        defaults: {	
            'ajuste2_ajuste1':'',
            'ajuste2_producto':'',
            'ajuste2_cantidad_entrada':'',
            'ajuste2_cantidad_salida':'',
            'ajuste2_costo':'',
            'ajuste2_costo_promedio':''
        }
    });

})(this, this.document);
