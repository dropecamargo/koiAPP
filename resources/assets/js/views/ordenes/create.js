/**
* Class CreateOrdenView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined){

    app.CreateOrdenView = Backbone.View.extend({

        el: '#ordenes-create',
        template: _.template( ($('#add-orden-tpl').html() || '') ),
        templateRemision: _.template( ($('#show-remision-tpl').html() || '') ),
        events: {
            'click .submit-orden': 'submitOrden',
            'submit #form-orden': 'onStore',
            'click .submit-visitas': 'submitVisita',
            'submit #form-visitas': 'onStoreVisita',
            'click .click-add-remision': 'clickAddRemision',
            'click .click-consult-remision': 'clickConsultRemision',
            'click .click-cerrar-orden': 'clickCloseOrden',
        },
        parameters: {
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            // Initialize
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            // Attributes
            this.msgSuccess = 'Orden guardada con exito!';
            this.$wraperForm = this.$('#render-form-orden');

            //Model Exists
            if( this.model.id != undefined ) {

                this.visita = new app.VisitaCollection();
                this.remision = new app.RemisionCollection();
            }
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
            this.$form = this.$('#form-orden');
            this.$formvisitasp = this.$('#form-visitas');

            // Model exist
            if( this.model.id != undefined ) {
                // Reference views
                this.referenceViews();
            }
            this.ready();
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

        },
        /**
        *Event Click to Button from orden
        */
        submitOrden:function(e){
            this.$form.submit();
        },

        /**
        * Event Create Orden
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                this.model.save( data, {patch: true, silent: true} );
            }
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
            // Weapper show remisones
            this.$wrapperRemsion = $('#render-main-remisiones');
            this.$wrapperRemsion.find('table').html('');
            // Open TecnicoActionView
            if ( this.tecnicoActionView instanceof Backbone.View ){
                this.tecnicoActionView.stopListening();
                this.tecnicoActionView.undelegateEvents();
            }

            this.tecnicoActionView = new app.TecnicoActionView({
                model: this.model,
                // collection: this.remrepu,
                parameters:{
                    action:'add'
                }
            });
            this.tecnicoActionView.render();
        },
        /**
        *
        */
        clickConsultRemision: function(e){
            // Weapper show remisones
            this.$wrapperRemsion = $('#render-main-remisiones');
            this.$wrapperRemsion.html( this.templateRemision() );

            this.remisionView = new app.RemisionView( {
                collection: this.remision,
                parameters: {
                    dataFilter: {
                        'orden_id': this.model.get('id')
                    }
                }
            });
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

            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();

            if( typeof window.initComponent.initICheck == 'function' )
                window.initComponent.initICheck();

            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();
            
            if( typeof window.initComponent.initDatePicker == 'function' )
                window.initComponent.initDatePicker();
            
            if( typeof window.initComponent.initTimePicker == 'function' )
                window.initComponent.initTimePicker();

            if( typeof window.initComponent.initInputMask == 'function' )
                window.initComponent.initInputMask();
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

                // CreateOrdenView undelegateEvents
                if ( this.createOrdenView instanceof Backbone.View ){
                    this.createOrdenView.stopListening();
                    this.createOrdenView.undelegateEvents();
                }

                // Redirect to edit orden
                Backbone.history.navigate(Route.route('ordenes.edit', { ordenes: resp.id}), { trigger:true });
            }
        }
    });

})(jQuery, this, this.document);
