/**
* Class CreateFacturapView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateFacturapView = Backbone.View.extend({

        el: '#facturap-create',
        template: _.template(($('#add-facturap-tpl').html() || '') ),
        events: {
            'click .submit-facturap': 'submitFormFacturap', 
            'submit #form-facturap' :'onStore',

            'submit #form-facturap2-impuesto': 'onStoreFacturap2',
            'submit #form-facturap2-retefuente': 'onStoreFacturap2',
            'submit #form-activo-fijo': 'onStoreActivoFijo',
            'submit #form-entrada-detalle': 'onStoreInventario',

            'change #facturap1_factura': 'onChangeRepeatFactura',
            'change #facturap2_impuesto': 'onChangeImpuesto',
            'change #facturap2_retefuente': 'onChangeRetefuente'
        },
        parameters: {
        },

        /**
        * Constructor Method
        */
        initialize : function() {

            // Reference collection
            this.detalleFacturap2 = new app.DetalleFacturasp2Collection();
            this.activoFijoList = new app.ActivoFijoList();
            this.entradasList = new app.EntradasList();
           
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

            this.$form = this.$('#form-facturap');

            // Spinner
            this.spinner = this.$('#spinner-main');
            
            //Reference views
            this.referenceViews();

            this.ready();
        },

        /*
        * Reference views
        */
        referenceViews:function(){ 
            this.detalleFacturap2View = new app.Facturap2DetalleView( {
                collection: this.detalleFacturap2,
                parameters: {
                    wrapper: this.spinner,
                    edit: true,
                    dataFilter: {
                        'id': this.model.get('id')
                    }
               }
            });
            this.activoFijoListView = new app.ActivosFijosListView( {
                collection: this.activoFijoList,
                parameters: {
                    wrapper: this.spinner,
                    edit: true,
                    form: this.$('#form-activo-fijo'),
                    dataFilter: {
                        'id': this.model.get('id')
                    }
               }
            });
            this.entradasListView = new app.EntradasListView( {
                collection: this.entradasList,
                parameters: {
                    wrapper: this.spinner,
                    edit: true,
                    form: this.$('#form-entrada-detalle'),
                    formDetail: this.$('#form-entrada'),
                    dataFilter: {
                        'id': this.model.get('id')
                    }
               }
            });
        },
        /**
        * Event submit facturap1
        */
        submitFormFacturap: function (e) {
            this.$form.submit();
        },
        /**
        * Event Create facturap1
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();
                var data = window.Misc.formToJson( e.target );
                    data.facturap2 = this.detalleFacturap2.toJSON();
                    data.activosfijos = this.activoFijoList.toJSON();
                    if (this.entradasList.length > 0){
                        data.entrada1 = window.Misc.formToJson(this.$('#form-entrada'));
                        data.entrada2 = this.entradasList.toJSON();
                    } 
                this.model.save( data, {patch: true, silent: true} );
            }   
        },
        /**
        * Store facturap2
        */
        onStoreFacturap2:function(e){
            if (!e.isDefaultPrevented()) {
                e.preventDefault();
                var data = window.Misc.formToJson( e.target ) ;
                    data.facturap1 = window.Misc.formToJson( this.$form ); 
                this.detalleFacturap2.trigger( 'store', data);
            }
        },
        /**
        * Store activo fijo
        */
        onStoreActivoFijo:function(e){
            if (!e.isDefaultPrevented()) {
                e.preventDefault();
                var data = window.Misc.formToJson( e.target ) ;
                this.activoFijoList.trigger( 'store', data);
            }
        },
        /**
        * Event store inventario validate temporal carDetail
        */
        onStoreInventario: function(e){

            this.$('#form-entrada').validator('validate');
            if (!e.isDefaultPrevented()) {
                e.preventDefault();
                var data = window.Misc.formToJson( e.target );
                    data.tipo = 'E';
                    data.lote = this.$('#entrada1_lote').val();
                    
                window.Misc.evaluateActionsInventory({
                    'data': data,
                    'wrap': this.spinner,
                    'callback': (function (_this) {
                        return function ( action , tipo)
                        {      
                            // Open InventarioActionView
                            if ( _this.inventarioActionView instanceof Backbone.View ){
                                _this.inventarioActionView.stopListening();
                                _this.inventarioActionView.undelegateEvents();
                            }
                            _this.inventarioActionView = new app.InventarioActionView({
                                model: _this.model,
                                collection: _this.entradasList,
                                parameters: {
                                    data: data,
                                    action: action,
                                    tipo: tipo
                                }
                            });
                            _this.inventarioActionView.render();
                        }
                    })(this)
                });
            }
        },
        /**
        *  Change for validation name factura
        */
        onChangeRepeatFactura: function (e) {
            e.preventDefault();
            var _this = this;
            if (_this.$('#facturap1_tercero').val() == '') {
                _this.$(e.target).val('');   
                return alertify.error('Campo de proveedor se encuentra vacio, por favor verifique información');
            }
            if (_this.$(e.target).val() != '') {
                // Validate
                $.ajax({
                    url: window.Misc.urlFull( Route.route( 'facturasp.validate') ),
                    type: 'GET',
                    data: {
                        factura: _this.$(e.target).val(),
                        tercero: _this.$('#facturap1_tercero').val()
                    },
                    beforeSend: function() {
                        window.Misc.setSpinner( _this.spinner );
                    }
                })
                .done(function(resp) {
                    window.Misc.removeSpinner( _this.spinner );
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
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    window.Misc.removeSpinner( _this.spinner );
                    alertify.error(thrownError);
                });
            }
        },
        /**
        *  Change for get porcentage y set valor with impuesto
        */
        onChangeImpuesto: function (e) {
            e.preventDefault();
            var _this = this;
            if (_this.$('#facturap1_subtotal').inputmask('unmaskedvalue') == 0) {
                return alertify.error('Campo de proveedor se encuentra vacio, por favor verifique información');
            }
            if (_this.$(e.target).val() != '') {
                // Impuesto
                $.ajax({
                    url: window.Misc.urlFull( Route.route( 'impuestos.show',{impuestos: _this.$(e.target).val()} ) ),
                    type: 'GET',
                    beforeSend: function() {
                        window.Misc.setSpinner( _this.spinner );
                    }
                })
                .done(function(resp) {
                    window.Misc.removeSpinner( _this.spinner );
                    // Eval porcentage
                    var porcentage = resp.impuesto_porcentaje;
                        subtotal = _this.calculateBase();
                    _this.$('#facturap2_impuesto_porcentaje').val(porcentage);
                    _this.$('#facturap2_base_impuesto').val((porcentage/100)  * subtotal);
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    window.Misc.removeSpinner( _this.spinner );
                    alertify.error(thrownError);
                });
            }else{
                _this.$('#facturap2_impuesto_porcentaje').val('');
                _this.$('#facturap2_base_impuesto').val('');
            }
        },
        /**
        *  Change for get porcentage y set valor with retefuente
        */
        onChangeRetefuente: function (e) {
            e.preventDefault();
            var _this = this;

            if (_this.$(e.target).val() != '') {
                // Retefuente
                $.ajax({
                    url: window.Misc.urlFull( Route.route( 'retefuentes.show',{retefuentes: _this.$(e.target).val()} ) ),
                    type: 'GET',
                    beforeSend: function() {
                        window.Misc.setSpinner( _this.spinner );
                    }
                })
                .done(function(resp) {
                    window.Misc.removeSpinner( _this.spinner );
                    // Eval porcentage
                    var porcentage = (_this.model.get('tercero_persona') == 'J' ) ? resp.retefuente_tarifa_juridico : resp.retefuente_tarifa_natural;
                        subtotal = _this.calculateBase();
                    _this.$('#facturap2_retefuente_porcentaje').val(porcentage);
                    _this.$('#facturap2_base_retefuente').val((porcentage/100) * subtotal );
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    window.Misc.removeSpinner( _this.spinner );
                    alertify.error(thrownError);
                });
            }else{
                _this.$('#facturap2_retefuente_porcentaje').val('');
                _this.$('#facturap2_base_retefuente').val('');
            }
        },
        /**
        *
        */
        calculateBase: function(){
            subtotal = this.$('#facturap1_subtotal').inputmask('unmaskedvalue'); 
            descuento = this.$('#facturap1_descuento').inputmask('unmaskedvalue'); 
            return subtotal - descuento; 
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initICheck == 'function' )
                window.initComponent.initICheck(); 

            if( typeof window.initComponent.initInputMask == 'function' )
                window.initComponent.initInputMask();
            
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();
            
            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();
            
            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();

            if( typeof window.initComponent.initDatePicker == 'function' )
                window.initComponent.initDatePicker();
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
            }
            window.Misc.redirect( window.Misc.urlFull( Route.route('facturasp.show', { facturasp: resp.id})) );
        }
    });

})(jQuery, this, this.document);
