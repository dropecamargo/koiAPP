/**
* Class CreateReciboView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateReciboView = Backbone.View.extend({

        el: '#recibo1-create',
        template: _.template(($('#add-recibo-tpl').html() || '') ),
        templateDetalleRecibo3: _.template(($('#add-recibomedio-tpl').html() || '') ),
        events: {
            'click .submit-recibo' :'submitFormRecibo',
            'submit #form-recibo1' :'onStore',
            'submit #form-recibo2' :'onStoreItem',
            'submit #form-recibo3' :'onStoreItem3',
            'change .change-concepto' :'changeConcepto',
            'change .change-medio-pago' :'changeMedioPago',
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
            this.$wraperForm = this.$('#render-form-recibo1');
            
            this.detalleReciboList = new app.DetalleReciboList();
            this.detalleReciboMedioPagoList = new app.DetalleRecibo3List();

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
            this.$form = this.$('#form-recibo1');

            this.$concepto = this.$('#recibo2_conceptosrc');
            this.$naturaleza = this.$('#recibo2_naturaleza');
            this.$valor = this.$('#recibo2_valor');
            
            this.referenceViews();
        },

        /**
        * Event submit recibo1
        */
        submitFormRecibo: function (e) {
            this.$form.submit();
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            //DetalleReciboList
            this.detalleRecibosView = new app.DetalleRecibosView( {
                collection: this.detalleReciboList,
                parameters: {
                    wrapper: this.$('#wrapper-recibo2'),
                    edit: true,
                    dataFilter: {
                        'recibo2': this.model.get('id')
                    }
               }
            });
            
            //DetalleRecibo3List
            this.detalleRecibos3View = new app.DetalleMedioPagoReciboView( {
                collection: this.detalleReciboMedioPagoList,
                parameters: {
                    edit: true,
                    dataFilter: {
                        'recibo3': this.model.get('id')
                    }
               }
            });
        },

        /*
        * Event Create recibo
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();
                var data = window.Misc.formToJson( e.target );
                    data.recibo2 = this.detalleReciboList.toJSON();
                    data.recibo3 = this.detalleReciboMedioPagoList.toJSON();
                this.model.save( data, {patch: true, silent: true} );
            }   
        },

        /**
        * Event add item detalle recibo
        */
        onStoreItem: function(e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                this.detalleReciboList.trigger( 'store', data );

                this.$concepto.val('').trigger('change');
                this.$naturaleza.val('').trigger('change');
                this.$valor.val('');
            }
        },
        /**
        * Event add item detalle recibo3
        */
        onStoreItem3: function(e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                    data.recibo2 = this.detalleReciboList.toJSON();
                this.detalleReciboMedioPagoList.trigger( 'store', data );
            }
        },
        /*
        * Render concepo
        */
        changeConcepto: function(e){
            var data = window.Misc.formToJson( e.target );
                data.tercero = this.$(e.currentTarget).attr('data-tercero');
                data.call = 'recibo';

            if( !_.isUndefined(data.recibo2_conceptosrc) && !_.isNull(data.recibo2_conceptosrc) && data.recibo2_conceptosrc != ''){
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
                                collection: _this.detalleReciboList,
                                parameters: {
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
        * Render detalle del medio de pago 
        */
        changeMedioPago:function(e){
            e.preventDefault();

            // Preparo sucursal
            var sucursal = this.$('#recibo1_sucursal').val();
            if (sucursal == '')
                return alertify.error('Campo de sucursal se encuentra vacío por favor ingrese una sucursal');

            // References
            this.$detailMedio = this.$('#detail-medio-pago');
            this.$detailMedio.empty();
            var _this = this;
                medio = _this.$(e.currentTarget).val();
                attributes = this.model.toJSON();
            if (!_.isUndefined(medio) && !_.isNull(medio) && medio != '') {
                $.ajax({
                    type: 'GET',
                    url: window.Misc.urlFull(Route.route('mediopagos.show',{ mediopagos: medio })),
                    beforeSend: function() {
                        window.Misc.setSpinner( _this.el );
                    }
                })
                .done(function(resp) {

                    window.Misc.removeSpinner( _this.el );
                    
                    attributes.resp = resp;
                    if (resp.mediopago_ch == 1) {
                        // Open CarteraActionView
                        if ( _this.carteraActionView instanceof Backbone.View ){
                            _this.carteraActionView.stopListening();
                            _this.carteraActionView.undelegateEvents();
                        }
                        // Obtengo id tercero del attr del select de concepto
                        resp.tercero = _this.$('#recibo2_conceptosrc').attr('data-tercero');
                        resp.recibo2 = _this.detalleReciboList.toJSON();
                        // Adjunto sucursal
                        resp.sucursal = sucursal;
                        
                        _this.carteraActionView = new app.CarteraActionView({
                            model: _this.model,
                            collection: _this.detalleReciboMedioPagoList,
                            parameters: {
                                data: resp,
                                action: 'mediopago',
                            }
                        });
                        _this.carteraActionView.render();

                    }else{  
                        _this.$detailMedio.empty().html( _this.templateDetalleRecibo3( attributes ) );
                    }

                    //Render form detalle medioPago
                    _this.ready();
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
            window.Misc.redirect( window.Misc.urlFull( Route.route('recibos.show', { recibos: resp.id}), { trigger:true }) );
        }
    });

})(jQuery, this, this.document);
