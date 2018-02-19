/**
* Class CreateGestionCobroView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateGestionCobroView = Backbone.View.extend({

        el: '#gestioncobro-create',
        template: _.template( ($('#add-gestioncobro-tpl').html() || '') ),
        events: {
            'submit #form-gestioncobro': 'onStore',
            'change .gestioncobro-koi-tercero': 'changeListDeuda'
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            // Attributes
            this.$wraperForm = this.$('#render-form-gestioncobro');

            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /**
        * Event Create Folder
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                this.model.save( data, {patch: true, silent: true} );
            }
        },

        /*
        * Render View Element
        */
        render: function() {
            var attributes = this.model.toJSON();
            this.$wraperForm.html( this.template(attributes) );

            this.ready();
        },
        /**
        * Event change whit reference factura3
        */
        changeListDeuda: function(e){
            e.preventDefault();
            var tercero = this.$(e.target).attr('data-tercero');

            // List deuda
            this.$templateTercero = _.template( ($('#add-tercero-cartera-tpl').html() || '') );
            this.detalleCarteraTercero = new app.DetalleCarteraTercero();

            // Detalle list deudas
            this.factura3ListView = new app.Factura3ListView({
                collection: this.detalleCarteraTercero,
                parameters: {
                    wrapper: this.el,
                    edit: false,
                    call: 'tercero',
                    template: this.$templateTercero,
                    dataFilter: {
                        'tercero': tercero,
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

            if( typeof window.initComponent.initICheck == 'function' )
                window.initComponent.initICheck();

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

                window.Misc.redirect( window.Misc.urlFull( Route.route('gestioncobros.index')) );
            }
        }
    });

})(jQuery, this, this.document);
