/**
* Class CreateTerceroView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateTerceroView = Backbone.View.extend({

        el: '#tercero-create',
        template: _.template( ($('#add-tercero-tpl').html() || '') ),
        events: {
            'submit #form-tercero': 'onStore',
            'submit #form-item-roles': 'onStoreRol',
            'submit #form-changed-password': 'onStorePassword',
            'ifChanged .change_employee': 'changedEmployee',
            'ifChanged #tercero_tecnico': 'changedTechnical',
            'ifChanged #tercero_vendedor': 'changedVendedor',
            'ifChanged #tercero_coordinador': 'changedCoordinador',
            'click .btn-add-tcontacto': 'addContacto'
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            // Initialize
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            // Attributes
            this.msgSuccess = 'Tercero guardado con exito!';
            this.$wraperForm = this.$('#render-form-tercero');

            // Model exist
            if( this.model.id != undefined ) {
                this.contactsList = new app.ContactsList();
                this.rolList = new app.RolList();
            }

            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /*
        * Render View Element
        */
        render: function(){
            var attributes = this.model.toJSON();
            this.$wraperForm.html( this.template(attributes) );

            this.$form = this.$('#form-tercero');
            this.$formAccounting = this.$('#form-accounting');
            this.$formEmployee = this.$('#form-employee');

            this.$checkEmployee = this.$('#tercero_empleado');
            this.$checkInternal = this.$('#tercero_interno');

            // Reset atributes uncheck empleado o interno
            this.$coordinador_por = this.$('#tercero_coordinador_por');
            this.$sucursal = this.$('#tercero_sucursal');
            this.$activo = this.$('#tercero_activo');
            this.$coordinador = this.$('#tercero_coordinador');
            this.$tecnico = this.$('#tercero_tecnico');
            this.$vendedor = this.$('#tercero_vendedor');

            // Reference unput fields
            this.$municipio = this.$('#tercero_municipio');
            this.$telefono = this.$('#tercero_telefono1');
            this.$direccion = this.$('#tercero_direccion');
            this.$nomenclatura = this.$('#tercero_nomenclatura');

            this.$username = this.$('#username');
            this.$password = this.$('#password');
            this.$password_confirmation = this.$('#password_confirmation');

            this.$wrapperEmployes = this.$('#wrapper-empleados');
            this.$wrapperCoordinador = this.$('#wrapper-coordinador');

            // Model exist
            if( this.model.id != undefined ) {
                // Reference views
                this.referenceViews();
            }
            this.ready();
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            // Contact list
            this.contactsListView = new app.ContactsListView( {
                collection: this.contactsList,
                parameters: {
                    edit: true,
                    wrapper: this.$('#wrapper-tcontacto'),
                    dataFilter: {
                        'tercero_id': this.model.get('id'),
                    }
               }
            });

            // Rol list
            this.rolesListView = new app.RolesListView( {
                collection: this.rolList,
                parameters: {
                    edit: true,
                    wrapper: this.$('#wrapper-roles'),
                    dataFilter: {
                        'tercero_id': this.model.get('id')
                    }
               }
            });
        },

        /**
        * Event Create Forum Post
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();
                
                var data = $.extend({}, window.Misc.formToJson( e.target ), window.Misc.formToJson( this.$formAccounting ), window.Misc.formToJson( this.$formEmployee ));
                this.model.save( data, {patch: true, silent: true} );
            }
        },

        /**
        * Event add item rol
        */
        onStoreRol: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                // Prepare global data
                var data = window.Misc.formToJson( e.target );
                this.rolList.trigger( 'store', data );
            }
        },

        addContacto: function() {
            this.contactsListView.trigger('createOne', this.model.get('id'), this.$municipio.val(),this.$telefono.val(), this.$direccion.val(), this.$nomenclatura.text(), this.contactsListView);
        },

        changedTechnical: function(e) {
            var selected = $(e.target).is(':checked');
            this.$coordinador_por.trigger('change');

            if( selected ) {
                this.$wrapperCoordinador.removeClass('hide');
            }else{
                this.$wrapperCoordinador.addClass('hide');
                this.$coordinador_por.val('');
            }
        },

        changedCoordinador: function(e){
            var selected = $(e.target).is(':checked');
            var nombre = this.model.get('tercero_nombre1')+' '+this.model.get('tercero_nombre2')+' '+this.model.get('tercero_apellido1')+' '+this.model.get('tercero_apellido2');
            var select = [{id: this.model.get('id') , text: nombre}];

            if( selected ) {
                this.$coordinador_por.select2({ data: select }).trigger('change');
                this.$coordinador_por.select2({ language: 'es', placeholder: 'Seleccione', allowClear: false });
            }else{
                this.$coordinador_por.find('option[value='+this.model.get('id')+']').remove();
            }
        },

        changedVendedor: function(e) {
            var selected = $(e.target).is(':checked');
            this.$coordinador_por.trigger('change');

            if( selected ) {
                this.$wrapperCoordinador.removeClass('hide');
            }else{
                this.$wrapperCoordinador.addClass('hide');
                this.$coordinador_por.val('');
            }
        },

        changedEmployee: function(e) {
            this.$sucursal.trigger('change');
            this.$coordinador_por.trigger('change');

            // Active if internal or employee
            if( this.$checkInternal.is(':checked') || this.$checkEmployee.is(':checked') ) {
                this.$wrapperEmployes.removeClass('hide')
            }else{
                this.$wrapperEmployes.addClass('hide')
                this.$sucursal.val('');
                this.$coordinador_por.val('');
                this.$activo.iCheck('uncheck');
                this.$vendedor.iCheck('uncheck');
                this.$coordinador.iCheck('uncheck');
                this.$tecnico.iCheck('uncheck');
            }
        },

        onStorePassword: function(e) {
            var _this = this;

            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                data.id = this.model.get('id');

                $.ajax({
                    type: "POST",
                    url: window.Misc.urlFull( Route.route('terceros.setpassword') ),
                    data: data,
                    beforeSend: function() {
                        window.Misc.setSpinner( _this.$('#wrapper-password') );
                    }
                })
                .done(function(resp) {
                    window.Misc.removeSpinner( _this.el );
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

                        alertify.success(resp.message);
                    }
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    window.Misc.removeSpinner( _this.$('#wrapper-password') );
                    alertify.error(thrownError);
                });
            }
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();

            if( typeof window.initComponent.initInputMask == 'function' )
                window.initComponent.initInputMask();

            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();

            if( typeof window.initComponent.initICheck == 'function' )
                window.initComponent.initICheck();

            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();
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

                alertify.success(this.msgSuccess);

                // CreateTerceroView undelegateEvents
                if ( this.createTerceroView instanceof Backbone.View ){
                    this.createTerceroView.stopListening();
                    this.createTerceroView.undelegateEvents();
                }

                // Redirect to edit tercero
                Backbone.history.navigate(Route.route('terceros.edit', { terceros: resp.id}), { trigger:true });
            }
        },
    });

})(jQuery, this, this.document);
