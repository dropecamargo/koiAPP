/**
* Class CreateGestionDeudoresView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateGestionDeudoresView = Backbone.View.extend({

        el: '#gestiondeudor-create',
        template: _.template( ($('#add-gestiondeudor-tpl').html() || '') ),
        events: {
            'submit #form-gestiondeudor': 'onStore',
            'change .deudor-koi-component': 'changeDeudor'
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            // Attributes
            this.$wraperForm = this.$('#render-form-gestiondeudor');

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
            this.deudor = this.$('#gestiondeudor_deudor');

            this.ready();
        },

        /**
        * Event Create Folder
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                    data.deudor_id = this.deudor.attr('referencia_deudor');

                this.model.save( data, {patch: true, silent: true} );
            }
        },

        /**
        * Event change deudor
        */
        changeDeudor: function (e){
            e.preventDefault();

            var tercero = this.$(e.target).attr('data-tercero');
            var deudor_nit = this.$(e.target).val();
            this.documentocobrolist = new app.DocumentoCobroList();

            // Documento Cobro list
            this.documentoCobroListView = new app.DocumentoCobroView({
                collection: this.documentocobrolist,
                parameters: {
                    dataFilter: {
                        tercero_id: tercero,
                        deudor_nit: deudor_nit
                    }
                }
            });
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

            if( typeof window.initComponent.initTimePicker == 'function' )
                window.initComponent.initTimePicker();
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

                window.Misc.redirect( window.Misc.urlFull( Route.route('gestiondeudores.index')) );
            }
        }
    });

})(jQuery, this, this.document);
