/**
* Class EditCajaMenorView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.EditCajaMenorView = Backbone.View.extend({

        el: '#cajamenor-create',
        template: _.template( ($('#add-cajamenor-tpl').html() || '') ),
        templateDetailt: _.template( ($('#add-cajamenor-detail-tpl').html() || '') ),
        events: {
            'click .submit-cajamenor' :'submitForm',
            'submit #form-cajamenor': 'onStore',
            'submit #form-detail-cajamenor': 'onStoreItem'
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            // Initialize
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            // Collection
            this.detalleCajaMenor = new app.CajaMenorDetalleList();

            // Spinner
            this.$spinner = this.$('#spinner-box');

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
            attributes.edit = true;
            this.$el.html( this.template(attributes) );

            this.$wraperDetail = this.$('#render-form-detail');
            this.$wraperDetail.html( this.templateDetailt({edit: attributes.edit}) );

            // Reference Fields
            this.$form = this.$('#form-cajamenor');
            this.$('#cajamenor2_cuenta').prop('disabled', true);

            // Reference views
            this.referenceViews();
            this.ready();
        },

        referenceViews:function(){
            this.detalleCajaMenorView = new app.DetalleCajaMenorView( {
                collection: this.detalleCajaMenor,
                parameters: {
                    edit: true,
                    reembolso: this.$('#cajamenor1_reembolso'),
                    template: this.templateDetailt,
                    wrapperTemplate: this.$wraperDetail,
                    dataFilter: {
                        'cajamenor': this.model.get('id')
                    }
               }
            });
        },

        /**
        * Event submit Caja Menor
        */
        submitForm: function (e) {
            this.$form.submit();
        },

        /**
        * Event Create Caja Menor
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                this.model.save( data, {patch: true, silent: true} );
            }
        },

        /**
        *   Evenet Submit item
        */
        onStoreItem: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                    data.cajamenor1 = this.model.get('id');
                this.detalleCajaMenor.trigger( 'store', data );
            }
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

            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();

            if( typeof window.initComponent.initDatePicker == 'function' )
                window.initComponent.initDatePicker();

            if( typeof window.initComponent.initInputMask == 'function' )
                window.initComponent.initInputMask();
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (model, xhr, opts) {
            window.Misc.setSpinner( this.$spinner );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            window.Misc.removeSpinner( this.$spinner );

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
                window.Misc.redirect( window.Misc.urlFull( Route.route('cajasmenores.edit', { cajasmenores: resp.id }), { trigger:true }) );
            }
        }
    });

})(jQuery, this, this.document);
