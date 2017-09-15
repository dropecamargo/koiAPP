/**
* Class AsientoActionView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.AsientoActionView = Backbone.View.extend({

        el: '#asiento-content',

        events: {

        },
        parameters: {
            data: { },
            actions: { },
        },

        /**
        * Constructor Method
        */
        initialize : function( opts ) {
            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.collection, 'sync', this.responseServer );
        },

        /*
        * Render View Element
        */
        render: function() {
    		this.runAction();
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

            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();

            if( typeof window.initComponent.initDatePicker == 'function' )
                window.initComponent.initDatePicker();

            if( typeof window.initComponent.initICheck == 'function' )
                window.initComponent.initICheck();
        },
        
		/**
        * Run actions
        */
        runAction: function( ) {
            var resp = this.evaluateNextAction(),
        		_this = this,
	            stuffToDo = {

                    'store' : function() {
                        _this.onStoreItem();
                    }
	            };

            if (stuffToDo[resp.action]) {
                stuffToDo[resp.action]();
            }
        },

        /**
        * Evaluate first action account
        */
        evaluateNextAction: function() {
            var index;
            for (index = this.parameters.actions.length - 1; index >= 0; --index) {
                action = this.parameters.actions[index];

                if(action.success == false) {
                    return action;
                }
            }

            return { action :'store' };
        },

        /**
        * Set success action
        */
        setSuccessAction: function(action) {
            var index;
            for (index = this.parameters.actions.length - 1; index >= 0; --index) {
                item = this.parameters.actions[index];

                if(item.action == action) {
                    item.success = true;
                }
            }
        },

        /**
        * is last action
        */
        isLastAction: function(action) {
            var index;
            for (index = this.parameters.actions.length - 1; index >= 0; --index) {
                item = this.parameters.actions[index];

                if(item.success == false && item.action != action) {
                    return false;
                }
            }
            return true;
        },

        /**
        * Validate action item asiento2 (facturap, ordenp, inventario, cartera)
        */
        validateAction: function ( options ) {

            options || (options = {});

            var defaults = {
                    'callback': null,
                    'action': null
                },
                data = {},
                settings = {}
                _this = this;

            settings = $.extend({}, defaults, options);

            // Prepare global data
            data.action = settings.action;
            data = $.extend({}, this.parameters.data, data);

            // Validate action
            $.ajax({
                url: window.Misc.urlFull(Route.route('asientos.detalle.validate')),
                type: 'POST',
                data: data,
                beforeSend: function() {
                    window.Misc.setSpinner( _this.$wraper );
                }
            })
            .done(function(resp) {
                window.Misc.removeSpinner( _this.$wraper );

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

                    // return callback
                    if( ({}).toString.call(settings.callback).slice(8,-1) === 'Function' )
                        settings.callback( resp );
                }

            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                window.Misc.removeSpinner( settings.wrap );
                alertify.error(thrownError);
            });
        },
        /**
        * Event add item Asiento Cuentas
        */
        onStoreItem: function (e) {
            // Model exist
            if( this.model.id != undefined ) {
                // Insert item
                this.collection.trigger( 'store', this.parameters.data );
            }else{
                // Create model
                this.model.save( this.parameters.data, {patch: true, silent: true} );
            }
        },
        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            if(!_.isUndefined(resp.success)) {
                if( resp.success ) {

                    // Close modals
                    this.$modalOp.modal('hide');
                    this.$modalIn.modal('hide');
                    this.$modalFp.modal('hide');
                    this.$modalCt.modal('hide');

                    window.Misc.clearForm( $('#form-item-asiento') );
                }
            }
        }
    });

})(jQuery, this, this.document);
