/**
* Class ShowOrdenView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ShowOrdenView = Backbone.View.extend({

        el: '#orden-show',

        /**
        * Constructor Method
        */
        initialize : function() {
            _.bindAll(this, 'onSessionRequestComplete');

            this.visita = new app.VisitaCollection();
            this.remision = new app.RemisionCollection();
            this.$uploaderFile = this.$('#fine-uploader');

            // Reference views
            this.uploadPictures();
            this.referenceViews();
        },

        /**
        * UploadPictures
        */
        uploadPictures: function(e) {
            var _this = this;

            this.$uploaderFile.fineUploader({
                debug: false,
                template: 'qq-template',
                session: {
                    endpoint: window.Misc.urlFull(Route.route('ordenes.imagenes.index')),
                    params: {
                        'orden_id': _this.model.get('id')
                    },
                    refreshOnRequest: false
                },
                allowMultipleItems: false,
                callbacks: {
                    onSessionRequestComplete: _this.onSessionRequestComplete,
                }
            });
        },

        onSessionRequestComplete: function (id, name, resp){
            this.$uploaderFile.find('.qq-upload-button').remove();
            this.$uploaderFile.find('.qq-upload-drop-area').remove();

            _.each( id, function(value, key){
                var previewLink = this.$uploaderFile.fineUploader('getItemByFileId', key).find('.preview-link');
                previewLink.attr("href", value.thumbnailUrl);
            }, this);
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
