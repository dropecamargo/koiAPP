/**
* Class ShowProductosView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ShowProductoView = Backbone.View.extend({

        el: '#producto-show',
        events: {
            'click .get-info-availability': 'getInfoAvailability',
            'click .edit-info-machine': 'editInfoMachine',
            'click .add-series': 'addSerie'
        },

        /**
        * Constructor Method
        */
        initialize: function() {
            // Collection the prodbode
            this.$('#browse-prodbode-table').hide();
            this.prodbodeList = new app.ProdbodeList();

            this.$modalGeneric = $('#modal-producto-generic');
        },

        /**
        * Event show series products father's
        */
        getInfoAvailability: function(e){
            e.preventDefault();

            // Model exist
            if( this.prodbodeList.length == 0 ) {

               this.$('#browse-prodbode-table').show();
                // Reference views
                this.referenceViews();
            }
        },

        /**
        * Event edit machines
        */
        editInfoMachine: function(e){
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                // tercero, tcontacto, vencimiento and servicio
                this.$modalGeneric.modal('show');

                // Open TecnicoActionView
                if ( this.productoActionView instanceof Backbone.View ){
                    this.productoActionView.stopListening();
                    this.productoActionView.undelegateEvents();
                }

                this.productoActionView = new app.ProductoActionView({
                    model: this.model,
                    parameters: {
                        call: 'M'
                    }
                });

                this.productoActionView.render();
            }
        },

        /**
        * Event add series products father's
        */
        addSerie: function(e){
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                // Show modal
                this.$modalGeneric.modal('show');

                // Open TecnicoActionView
                if ( this.productoActionView instanceof Backbone.View ){
                    this.productoActionView.stopListening();
                    this.productoActionView.undelegateEvents();
                }

                this.productoActionView = new app.ProductoActionView({
                    model: this.model,
                    parameters: {
                        call: 'S'
                    }
                });

                this.productoActionView.render();
            }
        },

        /**
        * Reference to views
        */
        referenceViews: function () {
            // Detalle asignaciones list
            this.prodbodeListView = new app.ProdbodeListView({
                collection: this.prodbodeList,
                parameters: {
                    wrapper: this.$('#wrapper-series'),
                    dataFilter: {
                        'producto_id': this.model.get('id')
                    }
                }
            });
        },
    });

})(jQuery, this, this.document);
