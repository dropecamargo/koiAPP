/**
* Class TreasuryActionView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});
(function ($, window, document, undefined) {

    app.TreasuryActionView = Backbone.View.extend({
        el: 'body',
        templateFactura: _.template( ($('#add-ajustep-factura-tpl').html() || '') ),

        events:{ 
            'submit #form-create-treasury-component-source': 'onStoreItemTreasury',
            'ifClicked .change-naturaleza': 'changeNaturaleza',
            'ifClicked .change-check': 'changeCheck',
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

            this.$modalTreasury = this.$('#modal-treasury-component');

            // Collections
            this.detallecuotaProveedor = new app.DetalleFacturap3List();

            // Listener 
            this.listenTo( this.detallecuotaProveedor, 'add', this.addOne );
            this.listenTo( this.detallecuotaProveedor, 'reset', this.addAll );

            this.ready();
        },

        /*
        * Render View Element
        */
        render: function() {
            var resp = this.parameters,
                _this = this,
                stuffToDo = {
                    'modalFacturaProveedor': function() {
                        _this.$modalTreasury.find('.content-modal').empty().html(_this.templateFactura( ));
                        _this.$modalTreasury.find('.modal-title').text('Tesoreria, Facturas proveedores ');

                        // Reference facturap cuotas
                        _this.referenceFacturaCuotas(resp);
                    },
                };
            if (stuffToDo[resp.action]) {
                stuffToDo[resp.action]();
            }
        },
        /**
        * reference Facturap3 cuotas  
        */
        referenceFacturaCuotas: function(attributes) 
        {
            this.$wraperErrorTreasury = this.$('#error-treasury');
            this.$wraperCuota = this.$('#browse-factura-cuota-list');
            this.detallecuotaProveedor.fetch({ reset: true, data: { tercero: attributes.data.tercero } });

            // Hide errors
            this.$wraperErrorTreasury.hide().empty();
            // Open modal
            this.$modalTreasury.modal('show');
        },
        /**
        * store form in modal
        */
        onStoreItemTreasury: function (e) 
        {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                // Hide modal && reset select
                if(this.parameters.data.call == 'ajustep'){
                    this.$('#ajustep2_documentos_doc').val('').change();
                }
                this.$modalTreasury.modal('hide');                
            }
        },
        /**
        * Render view task by model
        * @param Object Model instance
        */
        addOne: function (facturap3Model) {
            var view = new app.Facturap3ItemView({
                model: facturap3Model,
                parameters:{
                    call: this.parameters.data.call,
                }
            });

            facturap3Model.view = view;
            this.$wraperCuota.append( view.render().el );
            this.ready();
        },

        /*
        * Render all view tast of the collection
        */
        addAll:function(){
            var _this = this;

            if( this.detallecuotaProveedor.length > 0){
                this.detallecuotaProveedor.forEach(function(model) {
                    _this.addOne(model);

                    var modelo = _.find(_this.collection.models, function(item){
                        return item.get('facturap3_id') == model.get('id');
                    });
                    
                    if (modelo instanceof Backbone.Model ){
                        if( _this.parameters.data.call == 'ajustep'){
                            if( modelo.get('ajustep2_naturaleza') == 'D' ){
                                _this.$('#debito_'+model.get('id')).iCheck('check');
                            }else if( modelo.get('ajustep2_naturaleza') == 'C' ){
                                _this.$('#credito_'+model.get('id')).iCheck('check');
                            }
                        }
                        _this.$("#check_"+model.get('id')).iCheck('check');
                        _this.$("#pagar_"+model.get('id')).val( modelo.get('facturap3_valor') );
                    }
                });
            }else{
                _this.addOne( facturap3Model = new app.Facturap3Model );
            }
        },
        // Event change check
        changeCheck: function(e){
            var selected = this.$(e.currentTarget).prop('checked');
            var id = this.$(e.currentTarget).attr('id');
                id = id.split("_");
            if( !selected ) {
                var modelo = this.detallecuotaProveedor.agregar(id[1], this.parameters.data, undefined);
                this.$('#pagar_'+id[1]).val( modelo.facturap3_valor );
                this.collection.trigger('store', modelo );
            }else{
                var modelo = this.detallecuotaProveedor.eliminar(id[1], this.parameters.data);
                this.collection.trigger('store', modelo );
                this.$('#pagar_'+id[1]).val('');
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
                var valor = this.$('#pagar_'+id[1]).inputmask('unmaskedvalue');
                var modelo = this.detallecuotaProveedor.agregar(id[1], this.parameters.data, naturaleza, valor);
                this.$('#pagar_'+id[1]).val( modelo.facturap3_valor );
                this.$('#check_'+id[1]).iCheck('check');
                this.collection.trigger('store', modelo );
            }
        },
        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();

            if( typeof window.initComponent.initInputMask == 'function' )
                window.initComponent.initInputMask();

            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();

            if( typeof window.initComponent.initDatePicker == 'function' )
                window.initComponent.initDatePicker();

            if( typeof window.initComponent.initICheck == 'function' )
                window.initComponent.initICheck();
        },

        responseServer: function ( model, resp, opts ) {
            if(!_.isUndefined(resp.success)) {
                if( resp.success ) {
                    // Close modals
                    this.$modalTreasury.modal('hide');

                    // Clear Form of car temp
                    if (!_.isUndefined(this.parameters.form)) 
                        window.Misc.clearForm(this.parameters.form);
                }
            }
        }

    });
})(jQuery, this, this.document);