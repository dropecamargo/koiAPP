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
            _.bindAll(this, 'onSessionRequestComplete');
            
            // Collection the prodbode
            this.$('#browse-prodbode-table').hide();
            this.prodbodeList = new app.ProdbodeList();

            this.$modalGeneric = $('#modal-producto-generic');
            this.$uploaderFile = $('.fine-uploader');

            this.showPictures();
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

        /**
        * showPictures
        */
        showPictures: function(e) {
            var _this = this;

            this.$uploaderFile.fineUploader({
                debug: false,
                template: 'qq-template',
                autoUpload: false,
                dragDrop: false,
                session: {
                    endpoint: window.Misc.urlFull( Route.route('productos.imagenes.index') ),
                    params: {
                        producto: _this.model.get('id'),
                    },
                    refreshOnRequest: false
                },
                thumbnails: {
                    placeholders: {
                        notAvailablePath: window.Misc.urlFull("build/css/placeholders/not_available-generic.png"),
                        waitingPath: window.Misc.urlFull("build/css/placeholders/waiting-generic.png")
                    }
                },
                callbacks: {
                    onSessionRequestComplete: _this.onSessionRequestComplete,
                },
            });

            this.$uploaderFile.find('.buttons').remove();
            this.$uploaderFile.find('.qq-upload-drop-area').remove();
        },

        onSessionRequestComplete: function (id, name, resp) {
            _.each( id, function (value, key){
                var previewLink = this.$uploaderFile.fineUploader('getItemByFileId', key).find('.preview-link');
                previewLink.attr("href", value.thumbnailUrl);
            }, this);
        },
    });

})(jQuery, this, this.document);
