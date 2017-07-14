/**
* Class RemRepuCollection of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.RemRepuCollection = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('ordenes.detalle.remrepuestos.index') );
        },
        model: app.RemRepu2Model,

        /**
        * Constructor Method
        */
        initialize : function(){
        },

        calculateCantida: function(id){
            // var x = _.find(this.models, function(item){
            //     return item.get('id') == id;
            // });
        
            // var fact = $('#facturado_'+x.get('id')).val();
            //     nofact = $('#nofacturado_'+x.get('id')).val();
            //     devo = $('#devuelto_'+x.get('id')).val();
            //     usad = $('#usado_'+x.get('id')).val();
            //     cantidad = x.get('remrepu2_cantidad');

            // var tot = parseInt(fact) + parseInt(nofact) + parseInt(devo) + parseInt(usad);

            //     // nofacts = $('#nofacturado_'+x.get('id')).attr('max');
            //     // devos = $('#devuelto_'+x.get('id')).attr('max');
            //     // usads = $('#usado_'+x.get('id')).attr('max');

            // var resta = parseInt( cantidad ) - parseInt( tot );
        },

        storeLegalizacion: function( data, wrapper ){
            var error = { success: false };

            _.each(this.models, function(item){
                console.log(item);
            });

            console.log(data);

            // var model = _.each(this.models, function(item){

            //     if(item instanceof Backbone.Model ) {
            //         item.save(data, {
            //             success : function(model, resp) {
            //                 if(!_.isUndefined(resp.success)) {
            //                     window.Misc.removeSpinner( wrapper );

            //                     // response success or error
            //                     var text = resp.success ? '' : resp.errors;
            //                     if( _.isObject( resp.errors ) ) {
            //                         text = window.Misc.parseErrors(resp.errors);
            //                     }

            //                     if( !resp.success ) {
            //                         alertify.error(text);
            //                         return error;
            //                     }
            //                 }
            //             },
            //             error : function(model, error) {
            //                 window.Misc.removeSpinner( wrapper );
            //                 alertify.error(error.statusText)
            //             }
            //         });
            //     }

            // });


            error.success = false;
            return error;
        }

   });
})(this, this.document);

