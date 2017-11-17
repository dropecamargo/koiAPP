/**
* Class ConfirmWindow
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});
(function ($, window, document, undefined) {

    app.AuthorizationsWindow = Backbone.View.extend({

        el: '#modal-authorizations-component',
		events: {
			'submit #form-authorizations-component' : 'onStore'
        },
        parameters: {
            template: null,
            titleConfirm: '',
            call: '',
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {

            // extends attributtes
            if( opts != undefined && _.isObject(opts.parameters) )
                this.parameters = _.extend({}, this.parameters, opts.parameters );
        },

        /**
        * Render View Element
        */
        render: function() {
            var attributes = {};

            // Extend attributes confirm window
           	_.extend(attributes, this.parameters.dataFilter);
            this.$el.find('.content-modal').html( this.parameters.template(attributes) );
            
            // Change modal title
            this.$el.find('.inner-title-modal').html( this.parameters['titleConfirm'] );
            
			this.$el.modal('show');
            this.$form = this.$('#form-authorizations-component');

            // Prepare route
            if (this.parameters.dataFilter.call == 'autorizaco') {
            	this.route = 'autorizacionesco.store';
            }
            this.ready();
        },

        /**
        *
        */
        onStore: function(e){
            if (!e.isDefaultPrevented()) {

            	e.preventDefault();

	       		// Prepare data
	       		var data = window.Misc.formToJson( this.$form );
					data.id = this.parameters.dataFilter.id;
					_this = this;

				$.ajax({	
				    url:  window.Misc.urlFull( Route.route( _this.route ) ),
				    type: 'POST',
				    data: data,
				    beforeSend: function() {
				        window.Misc.setSpinner( _this.el );
				    }
				})
				.done(function(resp) {
				    window.Misc.removeSpinner( _this.el );

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

			            if (_this.parameters.dataFilter.call == 'autorizaco') {
			       			window.Misc.successRedirect( resp.msg, window.Misc.urlFull(Route.route('pedidosc.show', { pedidosc: resp.id })) );
			            }
				    }
				})
				.fail(function(jqXHR, ajaxOptions, thrownError) {
				    window.Misc.removeSpinner( _this.el );
				    alertify.error(thrownError);
				});
       		}
        },
        /**
        * fires libraries js
        */
        ready: function () {
            
            // to fire plugins    
            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();
            if( typeof window.initComponent.initDatePicker == 'function' )
                window.initComponent.initDatePicker();
        }
   });

})(jQuery, this, this.document);