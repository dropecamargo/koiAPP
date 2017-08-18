/**
* Class CreateEgresoView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateEgresoView = Backbone.View.extend({

        el: '#egreso1-create',
        template: _.template(($('#add-egreso-tpl').html() || '') ),
        events: {
            'click .submit-egreso' : 'submitForm',
            'submit #form-egreso1' : 'onStore',
            'submit #form-egreso2' : 'onStoreItem',
            'change #egreso2_tipopago': 'changeTipoPago'
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

            // Collections
            this.detalleEgreso = new app.DetalleEgresoList();

            // Attributes
            this.$wraperForm = this.$('#render-form-egreso1');

            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );            
            
            this.ready();
        },


        /*
        * Render View Element
        */
        render: function() {
            var attributes = this.model.toJSON();
            this.$wraperForm.html( this.template(attributes) );
            this.$form = this.$('#form-egreso1');
            this.$formDetail = this.$('#form-egreso2');

            this.referenceViews();
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            this.detalleEgresoView = new app.DetalleEgresosView( {
                collection: this.detalleEgreso,
                parameters: {
                    wrapper: this.el,
                    form: this.$formDetail,
                    edit: true,
                    dataFilter: {
                        'id': this.model.get('id'),
                    }
               }
            });
        },
        /**
        * Event submit recibo1
        */
        submitForm: function (e) {
            this.$form.submit();
        },

        /**
        * Event Create Egreso
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                    data.detalle = this.detalleEgreso.toJSON()
                this.model.save( data, {patch: true, silent: true} );                
            }
        },

        /**
        * Event add item detalle egreso
        */
        onStoreItem: function(e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                this.detalleEgreso.trigger( 'store', data );
            }
        },

        /**
        * Event open modals
        */
        changeTipoPago: function (e) {

            var data = window.Misc.formToJson( e.target );
                data.tercero = this.$(e.currentTarget).attr('data-tercero');
                data.call = 'egreso';

            if( !_.isUndefined(data.egreso2_tipopago) && !_.isNull(data.egreso2_tipopago) && data.egreso2_tipopago != ''){
                window.Misc.evaluateActionsTreasury({
                    'data': data,
                    'wrap': this.$el,
                    'callback': (function (_this) {
                        return function ( action )
                        {      
                            // Open TreasuryActionView
                            if ( _this.treasuryActionView instanceof Backbone.View ){
                                _this.treasuryActionView.stopListening();
                                _this.treasuryActionView.undelegateEvents();
                            }

                            _this.treasuryActionView = new app.TreasuryActionView({
                                model: _this.model,
                                collection: _this.detalleEgreso,
                                parameters: {
                                    data: data,
                                    action: action,
                                }
                            });
                            _this.treasuryActionView.render();
                        }
                    })(this)
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

            if( typeof window.initComponent.initInputMask == 'function' )
                window.initComponent.initInputMask();
            
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();
            
            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();

            if( typeof window.initComponent.initDatePicker == 'function' )
                window.initComponent.initDatePicker();
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
            }
            window.Misc.redirect( window.Misc.urlFull( Route.route('egresos.show', { egresos: resp.id}), { trigger:true }) );
        }
    });

})(jQuery, this, this.document);
