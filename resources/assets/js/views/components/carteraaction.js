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
        templateMedioCh: _.template( ($('#add-ch-recibo-tpl').html() || '') ),
        templateChd: _.template( ($('#add-ch-devuelto-tpl').html() || '') ),
    	events:{ 
            'submit #form-concepto-factura-component': 'onStore',
            'submit #form-mediopago-component': 'onStoreMedio',
            'submit #form-chd-component': 'onStoreChd',
            'ifClicked .change-check': 'changeCheck',
            'ifClicked .change-check-medio': 'changeCheckMedio',
            'ifClicked .click-concepto-chd': 'changeCheckChd',
            'ifClicked .change-naturaleza': 'changeNaturaleza',
            'change .change-pagar': 'changePagar',
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

            if( this.parameters.data.call == 'ajustesc'){
                this.template = this.parameters.template;
            }

            this.$modal = this.$('#modal-concepto-factura-component');
            this.$modalMedio = this.$('#modal-mediopago-component');
            this.$modalChd = this.$('#modal-chdevueltos-component');
            
            // Collection 
            this.detalleFacturaList = new app.DetalleFactura3List();
            this.detalleChposFechado = new app.DetalleChposFechadoList();
            this.chDevueltoList = new app.ChDevueltoList();

            this.$concepto = this.parameters.data.call == 'recibo' ? this.$('#recibo2_conceptosrc') : this.$('#nota1_conceptonota');

            this.listenTo( this.detalleFacturaList, 'add', this.addOne );
            this.listenTo( this.detalleFacturaList, 'reset', this.addAll );

            this.listenTo( this.detalleChposFechado, 'add', this.addOneCh );
            this.listenTo( this.detalleChposFechado, 'reset', this.addAllCh );

            this.listenTo( this.chDevueltoList, 'add', this.addOneChd );
            this.listenTo( this.chDevueltoList, 'reset', this.addAllChd );

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
                        _this.$modal.find('.content-modal').empty().html( _this.template() );

                        // Reference 
                        _this.reference(resp);
                    },
                    'modalChequesDevueltos' : function(){
                        _this.$modalChd.find('.content-modal').empty().html( _this.templateChd() );
                        // Reference
                        _this.referenceChDevuelto(resp);
                    },
                    'mediopago': function(){
                        _this.$modalMedio.find('.content-modal').empty().html( _this.templateMedioCh() );
                        // Reference 
                        _this.referenceMedioPago(resp);
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

        onStoreMedio: function(e){
            e.preventDefault();
            this.$modalMedio.modal('hide');
        },
        onStoreChd: function(e){
            e.preventDefault();
            // Hide modal && reset select
            if(this.parameters.data.call == 'recibo'){
                this.$concepto.val('').trigger('change');
            }
            this.$modalChd.modal('hide');
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
        /**
        * Reference ChDevuelto
        */
        referenceChDevuelto(attributes){
            this.$wraper = this.$('#modal-wrapper-ch-devuelto');
            this.$wraperChd = this.$('#browse-chd-list');
    
            this.chDevueltoList.fetch({ reset: true, data: { tercero: attributes.data.tercero } });

            // Open modal
            this.$modalChd.modal('show');
        },
        /**
        * Reference medio de pago cheque 
        */
        referenceMedioPago: function(attributes){
            this.$wraper = this.$('#modal-wrapper-concepto-factura');
            this.$wraperForm = this.$modal.find('.content-modal');
            this.$wraperCh = this.$('#browse-cheque-list');

            this.detalleChposFechado.fetch({ reset: true, data: { tercero: attributes.data.tercero, sucursal: attributes.data.sucursal }})

            // Open modal
            this.$modalMedio.modal('show');
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
        // Event change click chd
        changeCheckChd: function(e){
            var selected = this.$(e.currentTarget).prop('checked');
            var id = this.$(e.currentTarget).attr('id');
                id = id.split("_");
            if( !selected ) {
                var modelo = this.chDevueltoList.agregar( id[1], this.parameters.data );
                this.collection.trigger('store', modelo );
            }
              
            this.ready();
        },
        // Evente change click check-box
        changeCheckMedio: function(e){
            var selected = this.$(e.target).is(':checked');
            var id = this.$(e.currentTarget).attr('id');
                id = id.split("_");
            if( !selected ) {
                var modelo = this.detalleChposFechado.findModel(id[1],this.parameters.data.id);
                    modelo.recibo2 = this.parameters.data.recibo2;
                this.collection.trigger('store', modelo );
            }
              
            this.ready();    
        },
        // Event change naturaleza D->debito C->credito
        changeNaturaleza: function (e){
            var selected = this.$(e.currentTarget).is(':checked');
            var id = this.$(e.currentTarget).attr('id');
            var naturaleza = '';
            id = id.split("_");

            if( !selected ){
                if( id[0] == 'debito'){
                    this.$('#credito_'+id[1]).iCheck('uncheck');
                    naturaleza = 'D';
                }else{
                    this.$('#debito_'+id[1]).iCheck('uncheck');
                    naturaleza = 'C';
                }

                var modelo = this.detalleFacturaList.agregar(id[1], this.parameters.data, naturaleza);
                this.$('#pagar_'+id[1]).val( modelo.factura3_valor );
                this.$('#check_'+id[1]).iCheck('check');
                this.collection.trigger('store', modelo );
            }else{
                var modelo = this.detalleFacturaList.eliminar(id[1], this.parameters.data);
                this.collection.trigger('store', modelo );
                this.$('#check_'+id[1]).iCheck('uncheck');
                this.$('#pagar_'+id[1]).val('');
                return;
            }
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
                    call: this.parameters.data.call,
                }
            });

            factura3Model.view = view;
            this.$wraperConcepto.append( view.render().el );
            this.ready();
        },

        /*
        * Render all view tast of the collection
        */
        addAll:function(){
            var _this = this;

            if( this.detalleFacturaList.length > 0){
                this.detalleFacturaList.forEach(function(model) {
                    _this.addOne(model);

                    var modelo = _.find(_this.collection.models, function(item){
                        return item.get('factura3_id') == model.get('id');
                    });
                    
                    if (modelo instanceof Backbone.Model ){
                        if( _this.parameters.data.call == 'ajustesc'){
                            if( modelo.get('ajustec2_naturaleza') == 'D' ){
                                _this.$('#debito_'+model.get('id')).iCheck('check');
                            }else if( modelo.get('ajustec2_naturaleza') == 'C' ){
                                _this.$('#credito_'+model.get('id')).iCheck('check');
                            }
                        }
                        _this.$("#check_"+model.get('id')).iCheck('check');
                        _this.$("#pagar_"+model.get('id')).val( modelo.get('factura3_valor') );
                    }
                });
            }else{
                _this.addOne( factura3Model = new app.Factura3Model );
            }
        },
        /**
        *
        */
        addOneCh: function(chposfechado2){
            var view = new app.DetalleChequeItemView({
                model: chposfechado2,
                parameters: {
                    call: true
                }
            });
            chposfechado2.view = view;
            this.$wraperCh.append( view.render().el );
            this.ready();
        },
        /**
        *
        */
        addAllCh:function(){
            this.detalleChposFechado.forEach( this.addOneCh, this );
        },
        /**
        * Add one chequedevuelto modal
        */
        addOneChd: function(chdevuelto){
            var view = new app.DetalleChdItemView({
                model: chdevuelto,
                parameters: {
                }
            });
            chdevuelto.view = view;
            this.$wraperChd.append( view.render().el );
            this.ready();
        },
        /**
        * foreach collection the chdevuelto
        */
        addAllChd:function(){
            this.chDevueltoList.forEach( this.addOneChd, this );
        },
    });
})(jQuery, this, this.document);