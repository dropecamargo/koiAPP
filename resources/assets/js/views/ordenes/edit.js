/**
* Class EditOrdenView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.EditOrdenView = Backbone.View.extend({

        el: '#ordenes-create',
        template: _.template( ($('#add-orden-tpl').html() || '') ),
        templateRemision: _.template( ($('#show-remision-tpl').html() || '') ),
        events: {
        	'click .submit-orden': 'submitOrden',
            'submit #form-orden': 'onStore',
            
        	'click .submit-visitas': 'submitVisita',
            'submit #form-visitas': 'onStoreVisita',

            'click .click-add-remision': 'submitRemision',
            'submit #form-remision': 'clickAddRemision',

            'click .submit-legalizacion': 'submitLegalizacion',
            'submit #form-legalizacion': 'clickAddlegalizacion',

            'change .sum-cantidad': 'changeCantidad',

            'click .click-cerrar-orden': 'clickCloseOrden',
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            _.bindAll(this, 'onCompleteLoadFile', 'onSessionRequestComplete');

        	//Model Exists
            this.visita = new app.VisitaCollection();
            this.remision = new app.RemisionCollection();
            this.remrepu = new app.RemRepuCollection();

            // Initialize
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );

            this.cantidad = {};
        },

        /*
        * Render View Element
        */
        render: function() {
            var attributes = this.model.toJSON();
            	attributes.edit = true;

            this.$el.html( this.template(attributes) );

            this.$form = this.$('#form-orden');
            this.$modalCreate =  $('#modal-create-remision');

            this.$formvisitasp = this.$('#form-visitas');
            this.$formremision = this.$('#form-remision');
            this.$formlegalizacion = this.$('#form-legalizacion');

            // Spinner
            this.spinner = this.$('#spinner-main');
            this.$uploaderFile = this.$('#fine-uploader');

            // Reference views and uploadPictures
            this.referenceViews();
            this.uploadPictures();

            // to fire plugins
            this.ready();
		},

		/**
        *Event Click to Button from orden
        */
        submitOrden:function(e){
            this.$form.submit();
        },

        /**
        * Event Create cotizacion
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                // Prepare global data
                var data = window.Misc.formToJson( e.target );
                this.model.save( data, {patch: true, silent: true} );
            }
        },

        referenceViews:function(){
            this.visitasView = new app.VisitasView( {
                collection: this.visita,
                parameters: {
                    edit: true,
                    wrapper: this.$('#wrapper-visitas'),
                    dataFilter: {
                        'orden_id': this.model.get('id')
                    }
                }
            });

            this.remisionView = new app.RemisionView( {
                collection: this.remision,
                parameters: {
                    wrapper: this.$('#wrapper-remision'),
                    dataFilter: {
                        'orden_id': this.model.get('id')
                    }
                }
            });

            this.remrepuView = new app.RemRepuView( {
                collection: this.remrepu,
                el: $('#browse-legalizacion-list'),
                parameters: {
                    call: 'index',
                    wrapper: this.$('#wrapper-legalizacion'),
                    dataFilter: {
                        'orden_id': this.model.get('id')
                    }
                }
            });
        },

        /*
        * Event Click to Button from visita
        */
        submitVisita:function(e){
            this.$formvisitasp.submit();
        },

        /**
        * Event Create visita
        */
        onStoreVisita: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                this.visita.trigger( 'store', data );
            }
        },

        /*
        * Event Click to Button from remision
        */
        submitRemision:function(e){
            this.$formremision.submit();
        },

        /*
        * Event add remision
        */
        clickAddRemision:function(e){
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                // Data sucursal y tecnico
                var data = window.Misc.formToJson( e.target );
                    data.orden_id = this.model.get('id');
                
                this.$modalCreate.modal('show');

                // Open TecnicoActionView
                if ( this.tecnicoActionView instanceof Backbone.View ){
                    this.tecnicoActionView.stopListening();
                    this.tecnicoActionView.undelegateEvents();
                }

                this.tecnicoActionView = new app.TecnicoActionView({
                    model: this.model,
                    collection: this.remision,
                    parameters: {
                        data: data,
                        remrepu2: this.remrepu,
                    }
                });

                this.tecnicoActionView.render();
            }
        },

        /*
        * Event Click to Button from legalizacion
        */
        submitLegalizacion:function(e){
            this.$formlegalizacion.submit();
        },

        /**
        * UploadPictures
        */
        uploadPictures: function(e) {
            var _this = this;

            this.$uploaderFile.fineUploader({
                debug: 0,
                template: 'qq-template',
                session: {
                    endpoint: window.Misc.urlFull( Route.route('ordenes.imagenes.index') ),
                    params: {
                        'orden_id': _this.model.get('id')
                    },
                    refreshOnRequest: 0
                },
                request: {
                    inputName: 'file',
                    endpoint: window.Misc.urlFull( Route.route('ordenes.imagenes.index') ),
                    params: {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        'orden_id': _this.model.get('id')
                    }
                },
                deleteFile: {
                    enabled: 1,
                    forceConfirm: 1,
                    confirmMessage: '¿Esta seguro de que desea eliminar este archivo de forma permanente? {filename}',
                    endpoint: window.Misc.urlFull( Route.route('ordenes.imagenes.index') ),
                    params: {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        'orden_id': _this.model.get('id')
                    }
                },
                validation: {
                    itemLimit: 5,
                    sizeLimit: ( 4 * 1024 ) * 1024, // 4mb,
                    allowedExtensions: ['jpeg', 'jpg', 'png']
                },
                messages: {
                    typeError: '{file} extensión no valida. Extensiones validas: {extensions}.',
                    sizeError: '{file} es demasiado grande, el tamaño máximo del archivo es {sizeLimit}.'
                },
                callbacks: {
                    onComplete: _this.onCompleteLoadFile,
                    onSessionRequestComplete: _this.onSessionRequestComplete
                }
            });
        },

        /**
        * complete upload of file
        * @param Number id
        * @param Strinf name
        * @param Object resp
        */
        onCompleteLoadFile: function (id, name, resp) {

            var $itemFile = this.$uploaderFile.fineUploader('getItemByFileId', id);
            this.$uploaderFile.fineUploader('setUuid', id, resp.id);
            this.$uploaderFile.fineUploader('setName', id, resp.name);
                
            var previewLink = this.$uploaderFile.fineUploader('getItemByFileId', id).find('.preview-link');
            previewLink.attr("href", resp.url);
        },

        onSessionRequestComplete: function (id, name, resp){
            
            _.each( id, function ( value, key){
                var previewLink = this.$uploaderFile.fineUploader('getItemByFileId', key).find('.preview-link');
                previewLink.attr("href", value.thumbnailUrl);
            }, this);
        },

        /*
        * Event add remision
        */
        clickAddlegalizacion: function(e){
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var _this = this;
                    data = window.Misc.formToJson( e.target );
                    data.orden_id = this.model.get('id');

                // legalizacion
                $.ajax({
                    url: window.Misc.urlFull( Route.route( 'ordenes.detalle.remrepuestos.legalizacion' ) ),
                    data: data,
                    type: 'POST',
                    beforeSend: function() {
                        window.Misc.setSpinner( _this.spinner );
                    }
                })
                .done(function(resp) {
                    window.Misc.removeSpinner( _this.spinner );
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

                        alertify.success('Se guardo con exito la legalización.');
                    }
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    window.Misc.removeSpinner( _this.spinner );
                    alertify.error(thrownError);
                });
            }
        },

        /**
        *
        */
        clickCloseOrden: function(e){
            e.preventDefault();
            var _this = this;
            // Cerrar orden
            $.ajax({
                url: window.Misc.urlFull( Route.route('ordenes.cerrar', { ordenes: _this.model.get('id') }) ),
                type: 'GET',
                beforeSend: function() {
                    window.Misc.setSpinner( _this.spinner );
                }
            })
            .done(function(resp) {
                window.Misc.removeSpinner( _this.spinner );

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

                    window.Misc.successRedirect( resp.msg, window.Misc.urlFull(Route.route('ordenes.show', { ordenes: _this.model.get('id') })) );
                }
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                window.Misc.removeSpinner( _this.spinner );
                alertify.error(thrownError);
            });
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();

            if( typeof window.initComponent.initICheck == 'function' )
                window.initComponent.initICheck();

            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();

            if( typeof window.initComponent.initDatePicker == 'function' )
                window.initComponent.initDatePicker();

            if( typeof window.initComponent.initInputMask == 'function' )
                window.initComponent.initInputMask();

            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();

            if( typeof window.initComponent.initTimePicker == 'function' )
                window.initComponent.initTimePicker();

            if( typeof window.initComponent.initFineUploader == 'function' )
                window.initComponent.initFineUploader();
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (model, xhr, opts) {
            window.Misc.setSpinner( this.spinner );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            window.Misc.removeSpinner( this.spinner );

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

				// Redirect to show view                
				window.Misc.redirect( window.Misc.urlFull( Route.route('ordenes.edit', { ordenes: resp.id}) ) );
            }
        }
    });

})(jQuery, this, this.document);
