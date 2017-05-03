/**
* Class CreatePedidoscView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreatePedidoscView = Backbone.View.extend({

        el: '#pedidosc-create',
        template: _.template(($('#add-pedidosc-tpl').html() || '') ),
        templateDetailt: _.template(($('#add-detailt-pedidosc-tpl').html() || '') ),

        events: {
            
            'click .submit-pedidosc' : 'submitForm',
            'submit #form-pedidoc1' :'onStore',
            'submit #form-detalle-pedidoc' :'onStoreItem',
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
            this.$wraperForm = this.$('#render-form-pedidosc');

            this.detallePedidoc = new app.PedidocDetalleCollection();
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

            this.$form = this.$('#form-pedidoc1');
            this.$divDetalle = this.$('#detalle-pedidoc1');

            //Render form detalle pedidoc
            this.$divDetalle.empty().html( this.templateDetailt( ) );
            //Reference views
            this.referenceViews();
        },
        /*
        *References the collection
        */
        referenceViews:function(){ 
            this.detallePedidocView = new app.PedidocDetalleView( {
                collection: this.detallePedidoc,
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
        * Event submit pedidoc1
        */
        submitForm: function (e) {
            this.$form.submit();
        },

        /**
        * Event Create Ajuste
        */
        onStore: function (e) {
            
            if (!e.isDefaultPrevented()) {
                e.preventDefault();
                var data = $.extend({}, window.Misc.formToJson( e.target ) , this.detallePedidoc.totalize());
                    data.detalle = this.detallePedidoc.toJSON();
                this.model.save( data, {patch: true, silent: true} );
            }   
        },
        /**
        *Event store item the collection
        */
        onStoreItem: function(e){
            if (!e.isDefaultPrevented()) {
                e.preventDefault();
                this.detallePedidoc.trigger( 'store', this.$(e.target) );
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
                this.$('#pedidoc2_descuento_porcentaje').prop('readonly',false);
                this.$('#pedidoc2_descuento_valor').prop('readonly',true);
                this.$('#pedidoc2_precio_venta').prop('readonly',true);
                this.$('#pedidoc2_precio_venta').prop('');
            }else if(radioBtn == 'desc_value'){
                this.$('#pedidoc2_descuento_valor').prop('readonly',false);
                this.$('#pedidoc2_descuento_porcentaje').prop('readonly',true);
                this.$('#pedidoc2_precio_venta').prop('readonly',true);
            }else{
                this.$('#pedidoc2_precio_venta').prop('readonly',false);
                this.$('#pedidoc2_descuento_porcentaje').prop('readonly',true);
                this.$('#pedidoc2_descuento_valor').prop('readonly',true);
            }

        },
        /**
        *Se aplican las operaciones matematicas para allar los descuentos
        */
        doDiscount: function(caseDiscount){
            switch(caseDiscount){
                case 'porcentaje':
                    var descuento = (this.$('#pedidoc2_descuento_porcentaje').val())/100;
                        valor = this.$('#pedidoc2_costo').inputmask('unmaskedvalue');    
                        descuento = descuento * valor;
                    this.$('#pedidoc2_descuento_valor').val(descuento);
                    this.$('#pedidoc2_precio_venta').val(valor-descuento);
                    break;
                case 'value':
                    var valor = this.$('#pedidoc2_descuento_valor').inputmask('unmaskedvalue');
                        costo = this.$('#pedidoc2_costo').inputmask('unmaskedvalue');    
                        venta = (costo-valor)*100;
                        descuento = 100 - (venta / costo);
                    this.$('#pedidoc2_precio_venta').val(costo-valor);
                    this.$('#pedidoc2_descuento_porcentaje').val(descuento.toFixed(2));
                    break;
                case 'finally':
                    var valor =  (this.$('#pedidoc2_precio_venta').inputmask('unmaskedvalue'))*100;
                        precio = this.$('#pedidoc2_costo').inputmask('unmaskedvalue');
                        descuento = 100 - (valor/precio);
                    this.$('#pedidoc2_descuento_porcentaje').val(descuento.toFixed(2));
                    this.$('#pedidoc2_descuento_valor').val(precio - (valor/100));
                default:      
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
            window.Misc.redirect( window.Misc.urlFull( Route.route('pedidosc.index')) );
        }
    });

})(jQuery, this, this.document);
