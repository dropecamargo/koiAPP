/**
* Class CreateSucursalView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateSucursalView = Backbone.View.extend({

        el: '#sucursales-create',
        template: _.template( ($('#add-sucursal-tpl').html() || '') ),
        events: {
            'submit #form-sucursales': 'onStore',
            'ifChanged .changed-location': 'checkLocation',
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            _.bindAll(this, 'onCompleteLoadFile', 'onSessionRequestComplete');

            // Attributes
            this.$wraperForm = this.$('#render-form-sucursal');

            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /*
        * Render View Element
        */
        render: function() {
            var attributes = this.model.toJSON();
            this.$wraperForm.html( this.template(attributes) );

            // References fields
            this.$sucursalDefecto = this.$("#sucursal_defecto");
            this.$locationCheck = this.$("#sucursal_ubicaciones");
            this.$uploaderFile = this.$(".fine-uploader");

            if(this.model.id != undefined){
                this.loadDataSelect();
            }

            this.uploadPictures();
            this.ready();
        },

        /**
        * Event Create Folder
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                /**
                * En el metodo post o crear es necesario mandar las imagenes preguardadas por ende se convierte toda la peticion en un texto plano FormData
                * El metodo put no es compatible con formData
                */
                if( this.model.id != undefined ){
                    var data = window.Misc.formToJson( e.target );
                    this.model.save( data, {patch: true, silent: true} );

                }else{
                    var data = window.Misc.formToJson( e.target );
                    this.$files = this.$uploaderFile.fineUploader('getUploads', {status: 'submitted'});
                    var formData = new FormData();
                    _.each(this.$files, function(file, key){
                        formData.append('imagenes[]', file.file );
                    });

                    // Recorrer archivos para mandarlos texto plano
                    _.each(data, function(value, key){
                        formData.append(key, value);
                    });

                    this.model.save( null, {
                        data: formData,
                        processData: false,
                        contentType: false
                    });
                }

            }
        },

        /**
        * Change check edit
        */
        checkLocation: function(e){
            var selected = $(e.target).is(':checked');
            if( selected ) {
                this.$sucursalDefecto.prop('required',true);
            }else{
                this.$sucursalDefecto.prop('required',false);
                this.$sucursalDefecto.val('').trigger('change');
            }
        },

        /**
        * Loader data of select locations
        */
        loadDataSelect: function(){
            var _this = this;
            var idSucursal = this.model.get('id');
            if( typeof(idSucursal) !== 'undefined' && !_.isUndefined(idSucursal) && !_.isNull(idSucursal) && idSucursal != '' ){
                $.ajax({
                    url: window.Misc.urlFull( Route.route('ubicaciones.index', {sucursal: idSucursal}) ),
                    type: 'GET',
                    beforeSend: function() {
                        window.Misc.setSpinner( _this.el );
                    }
                })
                .done(function(resp) {
                    window.Misc.removeSpinner( _this.el );
                    _this.$sucursalDefecto.empty().val(0);
                    _this.$sucursalDefecto.append("<option value=></option>");
                    (resp.length > 0) ? _this.$locationCheck.iCheck('check',true) : '' ;

                    _.each(resp, function(item){
                        _this.$sucursalDefecto.append("<option value="+item.id+">"+item.ubicacion_nombre+"</option>");
                        if (_this.model.get('sucursal_defecto') == item.id) {
                            _this.$sucursalDefecto.val(item.id).change();
                        }
                    });
                });
            }
        },

        /**
        * UploadPictures
        */
        uploadPictures: function(e) {
            var _this = this,
                autoUpload = false;
                session = {};
                deleteFile = {};
                request = {};


            // Model exists
            if( this.model.id != undefined ){
                var session = {
                    endpoint: window.Misc.urlFull( Route.route('sucursales.imagenes.index') ),
                    params: {
                        sucursal: this.model.get('id'),
                    },
                    refreshOnRequest: false
                }

                var deleteFile = {
                    enabled: true,
                    forceConfirm: true,
                    confirmMessage: '¿Esta seguro de que desea eliminar este archivo de forma permanente? {filename}',
                    endpoint: window.Misc.urlFull( Route.route('sucursales.imagenes.index') ),
                    params: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        sucursal: this.model.get('id')
                    }
                }

                var request = {
                    inputName: 'file',
                    endpoint: window.Misc.urlFull( Route.route('sucursales.imagenes.index') ),
                    params: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        sucursal: this.model.get('id')
                    }
                }

                var autoUpload = true;
            }

            this.$uploaderFile.fineUploader({
                debug: false,
                template: 'qq-template',
                multiple: true,
                interceptSubmit: true,
                autoUpload: autoUpload,
                omitDefaultParams: true,
                session: session,
                request: request,
                retry: {
                    maxAutoAttempts: 3,
                },
                deleteFile: deleteFile,
                thumbnails: {
                    placeholders: {
                        notAvailablePath: window.Misc.urlFull("build/css/placeholders/not_available-generic.png"),
                        waitingPath: window.Misc.urlFull("build/css/placeholders/waiting-generic.png")
                    }
                },
                validation: {
                    itemLimit: 10,
                    sizeLimit: ( 3 * 1024 ) * 1024, // 3mb,
                    allowedExtensions: ['jpeg', 'jpg', 'png']
                },
                messages: {
                    typeError: '{file} extensión no valida. Extensiones validas: {extensions}.',
                    sizeError: '{file} es demasiado grande, el tamaño máximo del archivo es {sizeLimit}.',
                    tooManyItemsError: 'No puede seleccionar mas de {itemLimit} archivos.',
                },
                callbacks: {
                    onComplete: _this.onCompleteLoadFile,
                    onSessionRequestComplete: _this.onSessionRequestComplete,
                },
            });
        },

        /**
        * complete upload of file
        * @param Number id
        * @param Strinf name
        * @param Object resp
        */
        onCompleteLoadFile: function (id, name, resp) {
            var itemFile = this.$uploaderFile.fineUploader('getItemByFileId', id);
            this.$uploaderFile.fineUploader('setUuid', id, resp.id);
            this.$uploaderFile.fineUploader('setName', id, resp.name);

            var previewLink = this.$uploaderFile.fineUploader('getItemByFileId', id).find('.preview-link');
            previewLink.attr("href", resp.url);
        },

        onSessionRequestComplete: function (id, name, resp) {
            _.each( id, function (value, key){
                var previewLink = this.$uploaderFile.fineUploader('getItemByFileId', key).find('.preview-link');
                previewLink.attr("href", value.thumbnailUrl);
            }, this);
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();

            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();

            if( typeof window.initComponent.initInputMask == 'function' )
                window.initComponent.initInputMask();

            if( typeof window.initComponent.initICheck == 'function' )
                window.initComponent.initICheck();

            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (model, xhr, opts) {
            window.Misc.setSpinner( this.el );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            window.Misc.removeSpinner( this.el );

            if(!_.isUndefined(resp.success)) {
                // response success or error
                var text = resp.success ? '' : resp.errors;
                if( _.isObject( resp.errors ) ) {
                    text = window.Misc.parseErrors(resp.errors);
                }

                if( !resp.success ) {
                    alertify.error(text);
                    return;
                }

                window.Misc.redirect( window.Misc.urlFull( Route.route('sucursales.index')) );
            }
        }
    });

})(jQuery, this, this.document);
