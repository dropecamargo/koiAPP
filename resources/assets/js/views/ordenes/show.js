/**
* Class ShowOrdenView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ShowOrdenView = Backbone.View.extend({

        el: '#orden-main',

        /**
        * Constructor Method
        */
        initialize : function() {
            // Model exist
            if( this.model.id != undefined ) {
                this.visita = new app.VisitaCollection();
                this.remision = new app.RemisionCollection();
                // Reference views
                this.referenceViews();
            }
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            this.visitasView = new app.VisitasView( {
                collection: this.visita,
                parameters: {
                    call: 'show',
                    edit:false,
                    wrapper: this.$('#wrapper-visitas'),
                    dataFilter: {
                        'orden_id': this.model.get('id')
                    }
               }
            });

            this.remisionView = new app.RemisionView( {
                collection: this.remision,
                parameters: {
                    dataFilter: {
                        'orden_id': this.model.get('id')
                    }
                }
            });
        }
    });

})(jQuery, this, this.document);
