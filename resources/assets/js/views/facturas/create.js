/**
* Class CreateFacturaView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateFacturaView = Backbone.View.extend({

        el: '#factura-create',
        template: _.template(($('#add-facturas-tpl').html() || '') ),

        events: {
            'click .submit-factura' : 'submitForm',
            'submit #form-factura1' :'onStore',
            'submit #form-detalle-factura' :'onStoreItem',
            'change #factura1_pedido' : 'referenceViewCollection',
            'click .a-click-modals-lotes-koi': 'renderModals',
            'change .desc-porcentage': 'changePorcentage',
            'change .desc-value': 'changeValue',
            'change .desc-finally': 'changeFinally',
            'ifChecked .desc': 'changeRadioBtn',
        },
        parameters: {
        },

        /**
        * Constructor Method
        */
        initialize : function() {

            // Attributes
            this.$wraperForm = this.$('#render-form-factura');
            this.detalleFactura = new app.DetalleFactura2Collection();

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

            this.$form = this.$('#form-factura1');
            this.$formDetail = this.$('#form-detalle-factura');

            if (this.$formDetail.length == 1) {
                this.referenceViews();
            }

        },
        /**
        * Event submit factura1
        */
        submitForm: function (e) {
            this.$form.submit();
        },
        /*
        *Reference fetch
        */
        referenceViewCollection: function(e){
            e.preventDefault();
            this.detalleFacturaView = new app.FacturaDetalle2View( {
                collection: this.detalleFactura,
                parameters: {
                    wrapper: this.el,
                    edit: true,
                    dataFilter: {
                        'id_pedido': this.$(e.currentTarget).val()
                    }
               }
            });
        },
        /*
        * References the collection
        */
        referenceViews:function(){
            this.detalleFacturaView = new app.FacturaDetalle2View( {
                collection: this.detalleFactura,
                parameters: {
                    wrapper: this.el,
                    edit: true,
                    dataFilter: {
                        'id': this.model.get('id')
                    }
               }
            });
        },
        /**
        * Event Create facturas
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                if (!this.detalleFactura.valid().success) {
                    return alertify.error('Por favor seleccionar LOTES en el vinculo de la serie del producto');
                }
                var data = $.extend({}, window.Misc.formToJson( e.target ) , this.detalleFactura.totalize());
                    data.factura2 = this.detalleFactura.toJSON();
                this.model.save( data, {patch: true, silent: true} );
            }
        },
        /**
        *Event store item the collection
        */
        onStoreItem: function(e){
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = $.extend({}, window.Misc.formToJson( e.target ) );
                data.sucursal = this.$('#pedidoc1_sucursal').val();
                this.detalleFactura.trigger( 'store', data);
            }
        },

        renderModals:function(e){
            e.preventDefault();
            var model = _.find(this.detalleFactura.models, function(item) {
                return item.get('id') == this.$(e.currentTarget).attr('data-id');
            });
            var data = {};
                data.producto_serie = model.get('producto_serie');
                data.producto_nombre = model.get('producto_nombre');
                data.tipo = 'S';
                data.producto_id = model.get('producto_id');
                data.sucursal = this.$('#factura1_sucursal').val();
            window.Misc.evaluateActionsInventory({
                'data': data,
                'wrap': this.$el,
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
                            collection: _this.detalleFactura,
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
        },
        /**
        *Event change input porcentage
        */
        changePorcentage: function(e){
            e.preventDefault();

            $('#desc_porcentage').iCheck('check');
            $('#desc_value').iCheck('uncheck');
            $('#desc_finally').iCheck('uncheck');

            // Make discount
            this.doDiscount('porcentaje');
        },
        /**
        *Event change  input value
        */
        changeValue: function(e){
            e.preventDefault();

            $('#desc_value').iCheck('check');
            $('#desc_porcentage').iCheck('uncheck');
            $('#desc_finally').iCheck('uncheck');

            this.doDiscount('value');
        },
        /**
        *Event change  input finally
        */
        changeFinally: function(e){
            e.preventDefault();

            $('#desc_finally').iCheck('check');
            $('#desc_porcentage').iCheck('uncheck');
            $('#desc_value').iCheck('uncheck');

            this.doDiscount('finally');
        },
        /**
        *Event change radio btn
        */
        changeRadioBtn: function(e){
            e.preventDefault();
            var radioBtn = this.$(e.currentTarget).attr('id');

            if( radioBtn == 'desc_porcentage'){
                this.$('#factura2_descuento_porcentaje').prop('readonly',false);
                this.$('#factura2_descuento_valor').prop('readonly',true);
                this.$('#factura2_precio_venta').prop('readonly',true);
                this.$('#factura2_precio_venta').prop('');
            }else if(radioBtn == 'desc_value'){
                this.$('#factura2_descuento_valor').prop('readonly',false);
                this.$('#factura2_descuento_porcentaje').prop('readonly',true);
                this.$('#factura2_precio_venta').prop('readonly',true);
            }else{
                this.$('#factura2_precio_venta').prop('readonly',false);
                this.$('#factura2_descuento_porcentaje').prop('readonly',true);
                this.$('#factura2_descuento_valor').prop('readonly',true);
            }

        },
        /**
        *   Se aplican las operaciones matematicas para allar los descuentos
        */
        doDiscount: function(caseDiscount){
            switch(caseDiscount){
                case 'porcentaje':
                    var descuento = (this.$('#factura2_descuento_porcentaje').val())/100;
                        valor = this.$('#factura2_costo').inputmask('unmaskedvalue');
                        descuento = descuento * valor;
                    this.$('#factura2_descuento_valor').val(descuento);
                    this.$('#factura2_precio_venta').val(valor-descuento);
                    break;
                case 'value':
                    var valor = this.$('#factura2_descuento_valor').inputmask('unmaskedvalue');
                        costo = this.$('#factura2_costo').inputmask('unmaskedvalue');
                        venta = (costo-valor)*100;
                        descuento = 100 - (venta / costo);
                    this.$('#factura2_precio_venta').val(costo-valor);
                    this.$('#factura2_descuento_porcentaje').val(descuento.toFixed(2));
                    break;
                case 'finally':
                    var valor =  (this.$('#factura2_precio_venta').inputmask('unmaskedvalue'))*100;
                        precio = this.$('#factura2_costo').inputmask('unmaskedvalue');
                        descuento = 100 - (valor/precio);
                    this.$('#factura2_descuento_porcentaje').val(descuento.toFixed(2));
                    this.$('#factura2_descuento_valor').val(precio - (valor/100));
                    break;
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
            window.Misc.redirect( window.Misc.urlFull( Route.route('facturas.show', { facturas: resp.id})) );

        }
    });
})(jQuery, this, this.document);
