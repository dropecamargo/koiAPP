/**
* Class CarteraActionView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});
(function ($, window, document, undefined) {
    app.CarteraActionView = Backbone.View.extend({
    	el: 'body',

        template: _.template( ($('#add-concepto-factura-tpl').html() || '') ),
    	events:{ 
            'submit #form-concepto-factura-component': 'onStore',
            'ifClicked .change-check': 'changeCheck',
            'change .change-pagar': 'changePagar'
        },
        parameters: {
            data: { },
        },

        /**
        * Constructor Method
        */
        initialize : function( opts ) {
            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            this.$modal = this.$('#modal-concepto-factura-component');
            
            // Collection 
            this.detalleFacturaList = new app.DetalleFactura3List();
            this.$concepto = this.parameters.data.call == 'recibo' ? this.$('#recibo2_conceptosrc') : this.$('#nota1_conceptonota');

            this.listenTo( this.detalleFacturaList, 'add', this.addOne );
            this.listenTo( this.detalleFacturaList, 'reset', this.addAll );

            this.ready();
        },

        /*
        * Render View Element
        */
        render: function() {
            var resp = this.parameters,
                _this = this,
                stuffToDo = {
                    'modalCartera': function() {
                        _this.$modal.find('.content-modal').empty().html(_this.template());

                        // Reference 
                        _this.reference(resp);
                    },
                    
                };
            if (stuffToDo[resp.action]) {
                stuffToDo[resp.action]();
            }
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
        },

        onStore: function(e){
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                // Hide modal && reset select
                if(this.parameters.data.call == 'recibo'){
                    this.$concepto.val('').trigger('change');
                }
                this.$modal.modal('hide');                
            }
        },

        /**
        * Reference
        */
        reference: function(atributes) {
            this.$wraper = this.$('#modal-wrapper-concepto-factura');
            this.$wraperForm = this.$modal.find('.content-modal');
            this.$wraperError = this.$('#error-concepto-factura');
            this.$wraperConcepto = this.$('#browse-concepto-factura-list');
    
            this.detalleFacturaList.fetch({ reset: true, data: { tercero: atributes.data.tercero } });

            // Hide errors
            this.$wraperError.hide().empty();

            // Open modal
            this.$modal.modal('show');
        },

        // Event change check
        changeCheck: function(e){
            var selected = this.$(e.currentTarget).prop('checked');
            var id = this.$(e.currentTarget).attr('id');
            id = id.split("_");

            if( !selected ) {
                var modelo = this.detalleFacturaList.agregar(id[1], this.parameters.data, 'check');
                this.$('#pagar_'+id[1]).val( modelo.factura3_valor );
                this.collection.trigger('store', modelo );
            }else{
                var modelo = this.detalleFacturaList.eliminar(id[1], this.parameters.data);
                this.collection.trigger('store', modelo );
                this.$('#pagar_'+id[1]).val('');
            }
              
            this.ready();
        },

        // Event change pagar
        changePagar: function(e){
            var valor = this.$(e.currentTarget).inputmask('unmaskedvalue');
            var id = this.$(e.currentTarget).attr('id');
            id = id.split("_");

            this.$('#check_'+id[1]).iCheck('check');
            var modelo = this.detalleFacturaList.agregar(id[1], this.parameters.data, 'input', valor);
            this.collection.trigger('store', modelo );

            this.ready();
        },

        /**
        * Render view task by model
        * @param Object Model instance
        */
        addOne: function (factura3Model) {
            var view = new app.Factura3ItemView({
                model: factura3Model,
                parameters:{
                }
            });

            factura3Model.view = view;
            this.$wraperConcepto.append( view.render().el );
            this.ready();
        },

        /*
        *Render all view tast of the collection
        */
        addAll:function(){
            var _this = this;

            if( this.detalleFacturaList.length > 0){
                this.detalleFacturaList.forEach(function(model) {
                    _this.addOne(model);

                    var modelo = _this.collection.validarC(model.get('factura1_numero'));
                    if(modelo.success){
                        _this.$("#check_"+model.get('id')).iCheck('check');
                        _this.$("#pagar_"+model.get('id')).val( modelo.valor );
                    } 
                });
            }else{
                _this.addOne( factura3Model = new app.Factura3Model );
            }
        },
    });
})(jQuery, this, this.document);