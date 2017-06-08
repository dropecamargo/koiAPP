/**
* Class ShowAnticiposView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ShowAnticiposView = Backbone.View.extend({

        el: '#anticipo-show',
        /**
        * Constructor Method
        */
        initialize : function() {
            // Model exist
            if( this.model.id != undefined ) {
                this.detalleAnticipoMedioPagoList = new app.DetalleAnticipo2List();
                this.detalleAnticipoConceptoList = new app.DetalleAnticipo3List();
                
                // Reference views
                this.referenceViews();
            }
        },

        /**
        * reference to views
        */
        referenceViews: function () {

            // DetalleAnticipoMedioPagoList
            this.detalleAnticiposMediosView = new app.DetalleAnticiposMediosView({
                collection: this.detalleAnticipoMedioPagoList,
                parameters: {
                    edit: false,
                    dataFilter: {
                        'anticipo2': this.model.get('id')
                    }
                }
            });
            
            //DetalleAnticipoConceptoList
            this.detalleAnticiposView = new app.DetalleAnticiposView( {
                collection: this.detalleAnticipoConceptoList,
                parameters: {
                    edit: false,
                    dataFilter: {
                        'anticipo3': this.model.get('id')
                    }
               }
            });
        }
    });
})(jQuery, this, this.document);
