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
            'click .click-add-remision': 'clickAddRemision',
            'click .click-cerrar-orden': 'clickCloseOrden',
        },

        /**
        * Constructor Method
        */
        initialize : function() {

        	//Model Exists
            this.visita = new app.VisitaCollection();
            this.remision = new app.RemisionCollection();


            // Initialize
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
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

            // Spinner
            this.spinner = this.$('#spinner-main');

            // Reference views
            this.referenceViews();

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
                    call: 'create',
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
                    call: 'create',
                    wrapper: this.$('#wrapper-remision'),
                    dataFilter: {
                        'orden_id': this.model.get('id')
                    }
                }
            });
        },

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
        * Event add remision
        */
        clickAddRemision:function(e){
            this.$modalCreate.modal('show');

            // Open TecnicoActionView
            if ( this.tecnicoActionView instanceof Backbone.View ){
                this.tecnicoActionView.stopListening();
                this.tecnicoActionView.undelegateEvents();
            }

            this.tecnicoActionView = new app.TecnicoActionView({
                model: this.model,
                collection: this.remision,
            });

            this.tecnicoActionView.render();
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
                    window.Misc.setSpinner( _this.el );
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

                    window.Misc.successRedirect( resp.msg, window.Misc.urlFull(Route.route('ordenes.show', { ordenes: _this.model.get('id') })) );
                }
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                window.Misc.removeSpinner( _this.el );
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
