/**
* Class TecnicoActionView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.TecnicoActionView = Backbone.View.extend({

        el: '#orden-content-section',
        templateRemision: _.template(($('#add-remision-tpl').html() || '')),
        templateFactura: _.template(($('#add-factura-tecnico-tpl').html() || '')),
        events: {
            'click .click-store-remsion': 'onStoreRemision',
            'click .click-add-item': 'submitForm',
            'submit #form-remrepu': 'onStoreItem',

            'click .click-store-factura': 'submitFormFactura',
            'submit #form-factura-tecnico': 'submitCloseOrden',
            'submit #form-factura-tecnico-detail': 'updateCurrencies',

            'click .click-render-item': 'clickRenderItem',

            'change .desc-porcentage': 'changePorcentage',
            'change .desc-value': 'changeValue',
            'change .desc-finally': 'changeFinally',
            'ifChecked .desc': 'changeRadioBtn',
        },
        parameters: {
            data: {},
            action: {}
        },

        /**
        * Constructor Method
        */
        initialize : function( opts ) {
            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            // Prepare collection
            this.remrepu = new app.RemRepuCollection();
            this.detalleFactura = new app.DetalleFactura2Collection();

            this.$modalCreate =  this.$('#modal-create-remision');
            this.$modalFactura =  this.$('#modal-create-factura');

            this.listenTo( this.collection, 'sync', this.responseServer );
        },

        /*
        * Render View Element
        */
        render: function() {
            var resp = this.parameters,
                _this = this,
                stuffToDo = {
                    'remision': function() {
                        _this.$modalCreate.modal('show');
                        var data = {sucursal: resp.data.remrempu1_sucursal, tipoproducto: resp.data.tipoajuste_tipoproducto};
                        _this.$modalCreate.find('.content-modal').empty().html( _this.templateRemision( data ) );
                        _this.$form =  _this.$('#form-remrepu');
                        _this.el = _this.$('#browse-legalizacions-list');

                        _this.referenceView();
                    },
                    'factura': function() {
                        _this.$modalFactura.modal('show');
                        _this.$modalFactura.find('.content-modal').empty().html( _this.templateFactura( _this.model.toJSON() ) );
                        _this.$formFactura =  _this.$('#form-factura-tecnico');

                        _this.$fieldSerie =_this.$('#producto_serie');
                        _this.$fieldNombre =_this.$('#producto_nombre');
                        _this.$fieldCantidad =_this.$('#factura2_cantidad');
                        _this.$fieldCosto =_this.$('#factura2_costo');
                        _this.$fieldIva =_this.$('#factura2_iva_porcentaje');

                        _this.referenceViewFacturar();
                        _this.ready();
                    }
                };
                
            if (stuffToDo[resp.action]) {
                stuffToDo[resp.action]();
            }
		},

        /**
        * Collection remrepu View
        */
        referenceView: function(){
            this.remRepuView = new app.RemRepuView( {
                collection: this.remrepu,
                el: this.el,
                parameters: {
                    edit: true,
                    call: 'store',
                    dataFilter: {
                        'remrepu2_remrepu1': 'remrepu2_remrepu1',
                    }
                }
            });
        },
        /**
        * Collection remrepu View
        */
        referenceViewFacturar: function(){
            // Detalle factura list
            this.factura2ListView = new app.FacturaDetalle2View({
                collection: this.detalleFactura,
                parameters: {
                    wrapper: this.el,
                    edit: false,
                    template: _.template(($('#add-afacturar-item-tpl').html() || '')),
                    dataFilter: {
                        orden_id: this.model.get('id')
                    }
                }
            });
        },

        /**
        * Sumbit form
        */
        submitForm: function(e){
            this.$form.submit();
        },
        /**
        * Sumbit form
        */
        submitFormFactura: function(e){
            this.$formFactura.submit();
        },

        /**
        * On store in collection
        */
        onStoreItem: function(e){
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                    data.sucursal = this.$('#remrepu2_serie').attr('data-sucursal');
                this.remrepu.trigger( 'store', data );
            }
        },

        /**
        * Store Remision (RemRepu1)
        */
        onStoreRemision: function(e){
            e.preventDefault();

            // Prepare data
            var data = [];
                data.detalle = this.remrepu.toJSON();
                data.remrepu_orden = this.model.get('id');
                data.tecnico = this.parameters.data.remrempu1_tecnico;
                data.sucursal = this.parameters.data.remrempu1_sucursal;
            this.collection.trigger( 'store', data );
        },

        /**
        *  Close orden and submit factura
        */
        submitCloseOrden: function(e){
            e.preventDefault();
            var _this = this;
            var data = window.Misc.formToJson( e.target );
                data.tercero = _this.model.get('tercero_nit');
                data.id_orden = _this.model.get('id');
                data.factura2 = _this.detalleFactura.toJSON();
            // Cerrar orden
            $.ajax({
                url: window.Misc.urlFull( Route.route('ordenes.cerrar') ),
                type: 'POST',
                data : data,
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

                    window.Misc.successRedirect( resp.msg, window.Misc.urlFull(Route.route('ordenes.show', { ordenes: _this.model.get('id') })) );
                }
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                window.Misc.removeSpinner( _this.spinner );
                alertify.error(thrownError);
            });
        },
        clickRenderItem: function(e) {
            e.preventDefault();
            var id = this.$(e.currentTarget).attr('data-id');
            var model = _.find(this.detalleFactura.models, function(item) {
                return item.get('id') == id;
            });
            this.$fieldNombre.val(model.get('producto_nombre')).attr('data-id', model.id);
            this.$fieldSerie.val(model.get('producto_serie'));
            this.$fieldCantidad.val(model.get('factura2_cantidad'));
            this.$fieldCosto.val(model.get('factura2_costo'));
            this.$fieldIva.val(model.get('factura2_iva_porcentaje'));
        },

        updateCurrencies: function(e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();
                var id = this.$fieldNombre.attr('data-id');
                var model = _.find(this.detalleFactura.models, function(item) {
                    return item.get('id') == id;
                });

                var data = window.Misc.formToJson( e.target );

                if (model instanceof Backbone.Model )
                    data.id = model.get('id');

                this.detalleFactura.trigger( 'store', data );
            }
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
                        valor = this.$fieldCosto.inputmask('unmaskedvalue');
                        descuento = descuento * valor;
                    this.$('#factura2_descuento_valor').val(descuento);
                    this.$('#factura2_precio_venta').val(valor-descuento);
                    break;
                case 'value':
                    var valor = this.$('#factura2_descuento_valor').inputmask('unmaskedvalue');
                        costo = this.$fieldCosto.inputmask('unmaskedvalue');
                        venta = (costo-valor)*100;
                        descuento = 100 - (venta / costo);
                    this.$('#factura2_precio_venta').val(costo-valor);
                    this.$('#factura2_descuento_porcentaje').val(descuento.toFixed(2));
                    break;
                case 'finally':
                    var valor =  (this.$('#factura2_precio_venta').inputmask('unmaskedvalue'))*100;
                        precio = this.$fieldCosto.inputmask('unmaskedvalue');
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

            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();

            if( typeof window.initComponent.initDatePicker == 'function' )
                window.initComponent.initDatePicker();

            if( typeof window.initComponent.initInputMask == 'function' )
                window.initComponent.initInputMask();

            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();

            if( typeof window.initComponent.initICheck == 'function' )
                window.initComponent.initICheck();
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

                this.parameters.remrepu2.fetch({ data: {orden_id: this.parameters.data.orden_id}, reset: true });
                this.$modalCreate.modal('hide');
            }
        }
    });

})(jQuery, this, this.document);
