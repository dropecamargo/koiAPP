/**
* Class ShowDeudorView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ShowDeudorView = Backbone.View.extend({

        el: '#deudores-show',

        /**
        * Constructor Method
        */
        initialize : function() {
            this.contactodeudorlist = new app.ContactoDeudorList();
            this.documentocobrolist = new app.DocumentoCobroList();

            // Reference views
            this.referenceViews();
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            //  Contacto deudor list
            this.contactoDeudorListView = new app.ContactoDeudorView({
                collection: this.contactodeudorlist,
                parameters: {
                    dataFilter: {
                        deudor_id: this.model.get('id')
                    }
                }
            });

            // Documento Cobro list
            this.documentoCobroListView = new app.DocumentoCobroView({
                collection: this.documentocobrolist,
                parameters: {
                    dataFilter: {
                        deudor_id: this.model.get('id')
                    }
                }
            });
        }
    });

})(jQuery, this, this.document);
