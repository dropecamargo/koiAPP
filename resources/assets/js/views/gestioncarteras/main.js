/**
* Class MainGestionCarterasView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainGestionCarterasView = Backbone.View.extend({

        el: '#gestioncarteras-main',
        events: {
            'click .submit-import': 'submitForm',
            'submit #form-gestioncarteras': 'onImport',
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            // Rerefences
            this.$form = this.$('#form-gestioncarteras');
        },

        /**
        * Event submit factura1
        */
        submitForm: function (e) {
            this.$form.submit();
        },

        /**
        * Event Create facturas
        */
        onImport: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var _this = this,
                    formData =  new FormData( e.target );

                $.ajax({
                    url: window.Misc.urlFull(Route.route('gestioncarteras.import')),
                    data: formData,
                    type: 'POST',
                    cache: false,
                    contentType: false,
                    processData: false,
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

                        window.Misc.successRedirect(resp.msg, window.Misc.urlFull( Route.route('gestioncarteras.index') ) );
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
