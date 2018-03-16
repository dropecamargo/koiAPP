/**
* Class ProductoActionView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ImportProductoActionView = Backbone.View.extend({

        el: 'body',
        events: {
            'click .btn-import': 'submitForm',
            'submit #form-import-component': 'onStore'
        },
        parameters: {
            action: {}
        },

        /**
        * Constructor Method
        */
        initialize : function( opts ) {
            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            this.$modal = $('#modal-import-file-component');

            this.$modal.find('.modal-title').text( 'Importando ' + this.parameters.title );
            this.$wrapper = this.$('#modal-wrapper-import-file');
            this.$modal.modal('show');

            this.$form = $('#form-import-component');
            this.ready();
        },

        submitForm: function(e) {

            this.$form.submit();
        },

        onStore: function(e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var _this = this,
                    formData =  new FormData( e.target );

                $.ajax({
                    url: _this.parameters.url,
                    data: formData,
                    type: 'POST',
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        window.Misc.setSpinner( _this.$wrapper );
                    }
                })
                .done(function(resp) {
                    window.Misc.removeSpinner( _this.$wrapper );
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

                        _this.$modal.modal('hide');
                        window.Misc.successRedirect( resp.msg, window.Misc.urlFull( Route.route(resp.destination + '.index') ) );
                    }
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    window.Misc.removeSpinner( _this.$wrapper );
                    alertify.error(thrownError);
                });
            }
        },

    	/**
        * fires libraries js
        */
        ready: function () {
            // to fire plugin
            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();

            if( typeof window.initComponent.initSelectFile == 'function' )
                window.initComponent.initSelectFile();
        },
    });

})(jQuery, this, this.document);
