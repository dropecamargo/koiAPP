/**
* Class ProductoActionView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ProductoActionView = Backbone.View.extend({

        el: '#producto-content-section',
        templateMachine: _.template(($('#edit-machine-tpl').html() || '')),
        events: {
            'click .submit-generic': 'submitForm',
            'submit #form-generic-producto': 'onStore',
        },
        parameters: {
            data: {},
            action: {}
        },

        /**
        * Constructor Method
        */
        initialize : function( opts ) {
            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            this.$modalGeneric = $('#modal-producto-generic');
            this.$formGeneric =  this.$('#form-generic-producto');
        },

        /*
        * Render View Element
        */
        render: function() {
            this.$modalGeneric.find('.content-modal').empty().html( this.templateMachine( this.parameters.data ) );
            this.ready();
		},

        /**
        * Sumbit form
        */
        submitForm: function(e){
            this.$formMachine.submit();
        },

    	/**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();

            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();

            if( typeof window.initComponent.initDatePicker == 'function' )
                window.initComponent.initDatePicker();

            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();
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

                this.$modalMachine.modal('hide');
            }
        }
    });

})(jQuery, this, this.document);
