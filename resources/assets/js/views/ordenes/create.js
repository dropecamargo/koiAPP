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
        events: {
            'click .submit-orden': 'submitOrden',
            'submit #form-orden': 'onStore',
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
            // this.msgSuccess = 'Orden guardada con exito!';

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
                attributes.edit = false;
            this.$el.html( this.template(attributes) );

            this.$form = this.$('#form-orden');

            // Spinner
            this.spinner = this.$('#spinner-main');

            // this ready
            this.ready();
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
            window.Misc.setSpinner( this.spinner );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            window.Misc.removeSpinner( this.spinner );
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
