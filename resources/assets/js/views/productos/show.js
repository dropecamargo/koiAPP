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
            'click .edit-info-machine': 'editInfoMachine'
        },

        /**
        * Constructor Method
        */
        initialize: function() {

           this.$('#browse-prodbode-table').hide();
            // Collection the prodbode
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
        * Event show series products father's
        */
        editInfoMachine: function(e){
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                // tercero, tcontacto, vencimiento and servicio
                this.$modalGeneric.modal('show');

                var data = {
                    tercero_nombre: this.model.get('tercero_nombre'),
                    tercero_nit: this.model.get('tercero_nit'),
                    tcontacto_nombre: this.model.get('tcontacto_nombre'),
                    tcontacto_telefono: this.model.get('tcontacto_telefono'),
                    producto_servicio: this.model.get('producto_servicio'),
                    producto_vencimiento: this.model.get('producto_vencimiento')
                }

                // Open TecnicoActionView
                if ( this.productoActionView instanceof Backbone.View ){
                    this.productoActionView.stopListening();
                    this.productoActionView.undelegateEvents();
                }

                this.productoActionView = new app.ProductoActionView({
                    model: this.model,
                    parameters: {
                        data: data,
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
