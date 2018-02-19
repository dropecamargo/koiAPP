/**
* Class CreateMedioPagoView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateMedioPagoView = Backbone.View.extend({

        el: '#mediopago-create',
        template: _.template( ($('#add-mediopago-tpl').html() || '') ),
        events: {
            'submit #form-mediopago': 'onStore',
            'ifChanged .change-check': 'changedCheck',
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            // Attributes
            this.$wraperForm = this.$('#render-form-mediopago');

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

            // References check
            this.$checkch = this.$('#mediopago_ch');
            this.$checkef = this.$('#mediopago_ef');

            this.ready();
        },

        /**
        * Event change Icheck
        */
        changedCheck:function(e){
            selected = this.$(e.currentTarget).is(':checked');
            filter = this.$(e.currentTarget).attr('id').split('_')[1];

            if ( selected && filter == 'ch' ) {
                this.$checkef.iCheck('uncheck');
            }else if( selected && filter == 'ef' ){
                this.$checkch.iCheck('uncheck');
            }
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

                window.Misc.redirect( window.Misc.urlFull( Route.route('mediopagos.index')) );
            }
        }
    });
})(jQuery, this, this.document);
