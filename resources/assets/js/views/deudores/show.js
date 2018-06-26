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
        events: {
            'click .btn-add-contactodeudor': 'addContacto',
            'click .open-gestiondeudor': 'openGestionCobro'
        },

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
        },

        openGestionCobro: function(e){
            e.preventDefault();

            // Open gestionDeudorActionView
            if ( this.gestionDeudorActionView instanceof Backbone.View ){
                this.gestionDeudorActionView.stopListening();
                this.gestionDeudorActionView.undelegateEvents();
            }

            this.gestionDeudorActionView = new app.GestionDeudorActionView({
                model: this.model,
            });

            this.gestionDeudorActionView.render();
        },

        /**
        * Evnet store contacto
        */
        addContacto: function() {
            this.contactoDeudorListView.trigger('createOne', this.model.get('id'), this.contactoDeudorListView);
        },
    });

})(jQuery, this, this.document);
