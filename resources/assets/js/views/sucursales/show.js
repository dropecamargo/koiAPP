/**
* Class ShowSucursalView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ShowSucursalView = Backbone.View.extend({

        el: '#sucursal-show',

        /**
        * Constructor Method
        */
        initialize: function() {
            _.bindAll(this, 'onSessionRequestComplete');

            this.$uploaderFile = this.$('.fine-uploader');
            this.showPictures();
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
                    endpoint: window.Misc.urlFull( Route.route('sucursales.imagenes.index') ),
                    params: {
                        sucursal: _this.model.get('id'),
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
