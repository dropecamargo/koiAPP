/**
* Class CreateContactoDeudorView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateContactoDeudorView = Backbone.View.extend({

        el: 'body',
        template: _.template( ($('#add-contactodeudor-tpl').html() || '') ),
        events: {
            'submit #form-contactodeudor-component': 'onStore'
        },
        parameters: {
        	deudor_id : null
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // Events
            this.listenTo( this.model, 'change:id', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );

            this.$modalComponent = this.$('#modal-contactodeudor-component');
        },

        /*
        * Render View Element
        */
        render: function(){
            // Attributes
            var attributes = this.model.toJSON();
            this.$modalComponent.find('.content-modal').html('').html( this.template( attributes ) );
            this.$wraperContent = this.$('#content-contactodeudor-component').find('.modal-body');

            // to fire plugins
            this.ready();

            this.$modalComponent.modal('show');
            return this;
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();

            if( typeof window.initComponent.initInputMask == 'function' )
                window.initComponent.initInputMask();

            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();
        },

        /**
        * Event Create Contact
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {

                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
				if( !_.isUndefined(this.parameters.deudor_id) && !_.isNull(this.parameters.deudor_id) && this.parameters.deudor_id != '') {
                	data.deudor_id = this.parameters.deudor_id;
                }
                this.model.save( data, {patch: true} );
            }
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (model, xhr, opts) {
            window.Misc.setSpinner( this.$wraperContent );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            window.Misc.removeSpinner( this.$wraperContent );

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

                if(this.collection instanceof Backbone.Collection) {
	                // Add model in collection
	            	this.collection.add(model);
	            }

            	this.$modalComponent.modal('hide');
                this.collection.fetch({ data: {deudor_id: this.parameters.deudor_id}, reset: true });
            }
        }
    });

})(jQuery, this, this.document);
