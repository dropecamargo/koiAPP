/**
* Class CreateAjustecView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateAjustecView = Backbone.View.extend({

        el: '#ajustec-create',
        template: _.template( ($('#add-ajustec-tpl').html() || '') ),
        templateDetailt: _.template( ($('#add-detail-tpl').html() || '') ),
        events: {
            'click .submit-ajustec' :'submitFormAjustec',
            'submit #form-ajustec': 'onStore',
            'submit #form-detail-ajustec': 'onStoreItem',
            'change .change-documento': 'changeDocumento',
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
            this.$wraperForm = this.$('#render-form-ajustec');
            this.detalleAjustec = new app.AjustecDetalleList();
            this.$templateFact = _.template( ($('#add-ajustec-factura-tpl').html() || '') );

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

            this.$form = this.$('#form-ajustec');

            // Reference views
            this.referenceViews();
            this.ready();  
        },

        referenceViews:function(){ 
            this.detalleAjustecView = new app.DetalleAjustecView( {
                collection: this.detalleAjustec,
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
            // Preparo sucursal
            var sucursal = this.$('#ajustec1_sucursal').val();
            if (sucursal == '')
                return alertify.error('Campo de sucursal se encuentra vacío por favor ingrese una sucursal');

            var data = window.Misc.formToJson( e.target );
                data.tercero = this.$(e.currentTarget).attr('data-tercero');
                data.sucursal = sucursal;
                data.call = 'ajustesc';

            if( !_.isUndefined(data.ajustec2_documentos_doc) && !_.isNull(data.ajustec2_documentos_doc) && data.ajustec2_documentos_doc != ''){
                window.Misc.evaluateActionsCartera({
                    'data': data,
                    'wrap': this.$el,
                    'callback': (function (_this) {
                        return function ( action )
                        {      
                            // Open CarteraActionView
                            if ( _this.carteraActionView instanceof Backbone.View ){
                                _this.carteraActionView.stopListening();
                                _this.carteraActionView.undelegateEvents();
                            }

                            _this.carteraActionView = new app.CarteraActionView({
                                model: _this.model,
                                collection: _this.detalleAjustec,
                                parameters: {
                                    template: _this.$templateFact,
                                    data: data,
                                    action: action,
                                }
                            });
                            _this.carteraActionView.render();
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
        * Event Create Folder
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                    data.detalle = this.detalleAjustec.toJSON();
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
                this.detalleAjustec.trigger( 'store', data );

                this.$('#ajustec2_documentos_doc').val(0).trigger('change');
                this.$('#ajustec2_naturaleza').val('');
                this.$('#ajustec2_valor').val('');
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

                window.Misc.redirect( window.Misc.urlFull( Route.route('ajustesc.show', { ajustesc: resp.id}), { trigger:true }) );
            }
        }
    });

})(jQuery, this, this.document);
