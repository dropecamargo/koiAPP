/**
* Class DetalleTipoAjusteList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.DetalleTipoAjusteList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('tiposajuste.detalle.index') );
        },
        model: app.TipoAjuste2Model,

        /**
        * Constructor Method
        */
        initialize : function(){
        },

        validar: function( data ) {
            var error = { success: false, message: '' };

            // Validate exist
            var modelExits = _.find(this.models, function(item) {
                return item.get('tipoproducto') == data.tipoproducto;
            });

            if(modelExits instanceof Backbone.Model ) {
                error.message = 'El tipo de producto '+ modelExits.get('tipoproducto_nombre') +' ya fue agregado.'
                return error;
            }

            error.success = true;
            return error;
        },
   });

})(this, this.document);
