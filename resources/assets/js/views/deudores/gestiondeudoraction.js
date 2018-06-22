/**
* Class GestionDeudorActionView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.GestionDeudorActionView = Backbone.View.extend({

        el: 'body',
        template: _.template(($('#create-gestiondeudoraction-tpl').html() || '')),
        events: {
            'click .submit-gesiondeudor': 'submitForm',
            'submit #form-create-gestiondeudor-component': 'onStore'
        },

        /**
        * Constructor Method
        */
        initialize : function( opts ) {
            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            this.$modal = $('#modal-create-gestiondeudor-component');
            this.$wraperError = this.$('#error-gestiondeudor-resource-component');
            this.$form = this.$('#form-create-gestiondeudor-component');
        },

        /*
        * Render View Element
        */
        render: function() {
            this.runAction();
		},

        runAction: function() {
            var attributes = this.model.toJSON();

            this.$modal.find('.modal-title').text('Gestión de deudor');
            this.$modal.find('.content-modal').empty().html( this.template( attributes ) );

            // Hide errors && Open modal
            this.$wraperError.hide().empty();
            this.$modal.modal('show');

            this.ready();
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();

            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();

            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();

            if( typeof window.initComponent.initTimePicker == 'function' )
                window.initComponent.initTimePicker();

            if( typeof window.initComponent.initDatePicker == 'function' )
                window.initComponent.initDatePicker();
        },

        /**
        * Event submit factura1
        */
        submitForm: function (e) {
            this.$form.submit();
        },

        /**
        *   Event update
        */
        onStore: function(e){
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var _this = this;
                var data = window.Misc.formToJson( e.target );
                    data.deudor = this.model.get('id');

                $.ajax({
                    type: "POST",
                    url: window.Misc.urlFull( Route.route('deudores.gestiondeudor') ),
                    data: data,
                    beforeSend: function() {
                        window.Misc.setSpinner( _this.el );
                    }
                })
                .done(function(resp) {
                    if(!_.isUndefined(resp.success)) {
                        window.Misc.removeSpinner( _this.el );

                        // response success or error
                        var text = resp.success ? '' : resp.errors;
                        if( _.isObject( resp.errors ) ) {
                            text = window.Misc.parseErrors(resp.errors);
                        }

                        if( !resp.success ) {
                            alertify.error(text);
                            return;
                        }

                        window.Misc.successRedirect( resp.msg, window.Misc.urlFull( Route.route('gestiondeudores.show', { gestiondeudores: resp.id })) );
                    }
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    window.Misc.removeSpinner( _this.el );
                    alertify.error(thrownError);
                });
            }
        },
    });
})(jQuery, this, this.document);
