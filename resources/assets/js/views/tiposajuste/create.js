/**
* Class CreateTipoAjusteView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateTipoAjusteView = Backbone.View.extend({

        el: '#tipoajuste-create',
        template: _.template( ($('#add-tipoajuste-tpl').html() || '') ),
        templateDetalle: _.template( ($('#detalle-tipoajuste-tpl').html() || '') ),
        events: {
            'click .submit-tipoajuste': 'submitTipoajuste',
            'submit #form-tipoajuste': 'onStore',
            'submit #form-detalle-tipoajuste': 'onStoreItem',
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            // Attributes
            this.$wraperForm = this.$('#render-form-tipoajuste');
            this.detalleTipoAjusteList = new app.DetalleTipoAjusteList();

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
            this.$wraperDetalle = this.$('#render-detalle');

            this.$wraperDetalle.html( this.templateDetalle() );

            // References
            this.$form = this.$('#form-tipoajuste');
            this.$formItem = this.$('#form-detallle-tipoajuste');

            this.referenceViews();
            this.ready();
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            // Detalle tipoajuste list
            this.detalleTipoAjusteListView = new app.DetalleTipoAjusteListView({
                collection: this.detalleTipoAjusteList,
                parameters: {
                    wrapper: this.el,
                    edit: true,
                    dataFilter: {
                        tipoajuste: this.model.get('id')
                    }
                }
            });
        },

        submitTipoajuste: function() {
            this.$form.submit();
        },

        /**
        * Event Create Tipo Ajuste
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                    data.detalle = this.detalleTipoAjusteList.toJSON();
                this.model.save( data, {patch: true, silent: true} );
            }
        },

        /**
        * Event Create Tipo Ajuste
        */
        onStoreItem: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target ) ;
                this.detalleTipoAjusteList.trigger('store', data);
            }
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

                window.Misc.redirect( window.Misc.urlFull( Route.route('tiposajuste.index')) );
            }
        }
    });

})(jQuery, this, this.document);
