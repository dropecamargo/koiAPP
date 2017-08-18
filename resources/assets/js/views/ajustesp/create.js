/**
* Class CreateAjustepView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateAjustepView = Backbone.View.extend({

        el: '#ajustep-create',
        template: _.template( ($('#add-ajustep-tpl').html() || '') ),
        templateDetailt: _.template( ($('#add-detail-tpl').html() || '') ),
        events: {
            'click .submit-ajustep' :'submitFormAjustec',
            'submit #form-ajustep': 'onStore',
            'submit #form-detail-ajustep': 'onStoreItem',
            'change .change-documento-treasury': 'changeDocumento',
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
            this.$wraperForm = this.$('#render-form-ajustep');
            this.detalleAjustep = new app.AjustepDetalleList();

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
            this.$wraperForm.html( this.template(attributes) );

            this.$wraperDetail = this.$('#render-form-detail');
            this.$wraperDetail.html( this.templateDetailt({}) );

            this.$form = this.$('#form-ajustep');

            // Reference views
            this.referenceViews();
            this.ready();  
        },

        referenceViews:function(){ 
            this.detalleAjustepView = new app.DetalleAjustepView( {
                collection: this.detalleAjustep,
                parameters: {
                    wrapper: this.el,
                    edit: true,
                    dataFilter: {
                        'id': this.model.get('id')
                    }
               }
            });
        },
        changeDocumento: function (e){
            // Preparo regional
            var regional = this.$('#ajustep1_regional').val();
            if (regional == '')
                return alertify.error('Campo de regional se encuentra vacío por favor ingrese una regional');

            var data = window.Misc.formToJson( e.target );
                data.tercero = this.$(e.currentTarget).attr('data-tercero');
                data.regional = regional;
                data.call = 'ajustep';

            if( !_.isUndefined(data.ajustep2_documentos_doc) && !_.isNull(data.ajustep2_documentos_doc) && data.ajustep2_documentos_doc != ''){
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
                                collection: _this.detalleAjustep,
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
        * Event submit recibo1
        */
        submitFormAjustec: function (e) {
            this.$form.submit();
        },

        /**
        * Event Create Ajustep
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                    data.detalle = this.detalleAjustep.toJSON();
                this.model.save( data, {patch: true, silent: true} );                
            }
        },

        /**
        *   Evenet Submit item
        */ 
        onStoreItem: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                this.detalleAjustep.trigger( 'store', data );

                this.$('#ajustep2_documentos_doc').val(0).trigger('change');
                this.$('#ajustep2_naturaleza').val('');
                this.$('#ajustep2_valor').val('');
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

            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();
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

                window.Misc.redirect( window.Misc.urlFull( Route.route('ajustesp.show', { ajustesp: resp.id}), { trigger:true }) );
            }
        }
    });

})(jQuery, this, this.document);
