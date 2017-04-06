/**
* Class InventarioActionView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});
(function ($, window, document, undefined) {

    app.InventarioActionView = Backbone.View.extend({
    	el: 'body',

        templateAddSeries: _.template( ($('#add-series-tpl').html() || '') ),
    	templateSeriesLotes: _.template( ($('#add-series-lotes-tpl').html() || '') ),
        templateAddItemRollo: _.template( ($('#add-itemrollo-tpl').html() || '') ),
        templateChooseItemsRollo: _.template( ($('#choose-itemrollo-tpl').html() || '') ),

    	events:{ 
            'submit #form-create-inventario-entrada-component-source': 'onStoreItemInventario',
            'change .cantidad-salidau-koi-inventario': 'changedCantidadUnidadesSalida',
            'click #btn-itemrollo-entradau-koi-inventario': 'clickAddItemRollo',
            'click .btn-remove-itemrollo-koi-inventario': 'clickRemoveItemRollo',
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

            this.$modalIn = this.$('#modal-inventario-component');
            
            // Collection item rollo
            this.itemRolloINList = new app.ItemRolloINList();
            //Collectio lotes
            this.LotesProducto = new app.ProductoLote();
            // Collection series producto
            this.productoSeriesINList = new app.ProductoSeriesINList();

            // Events Listeners
            this.listenTo( this.LotesProducto, 'reset', this.addAllProductoLote );

            this.listenTo( this.itemRolloINList, 'add', this.addOneItemRolloInventario );
            this.listenTo( this.itemRolloINList, 'reset', this.addAllItemRolloInventario );
            
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.collection, 'sync', this.responseServer );
        },

        /*
        * Render View Element
        */
        render: function() {
            var resp = this.parameters,
                _this = this,
                stuffToDo = {
                    'modalSerie': function() {
                        if (resp.tipoAjuste== 'E') {
                            _this.$modalIn.find('.content-modal').empty().html(_this.templateAddSeries( ));
                            _this.$modalIn.find('.modal-title').text('Inventario, Entradas De Productos ');
                            // Reference inventario
                            _this.referenceSerie(resp);
                        }else{
                            // Reference inventario
                            _this.$('#ajuste2_cantidad_salida').val(1).prop('readonly', true);
                            _this.referenceSerie(resp);
                        }

                    },
                    
                    'ProductoMetrado': function(){
                        if (resp.tipoAjuste == 'E') {
                            _this.$modalIn.find('.content-modal').empty().html(_this.templateAddItemRollo(resp) );
                            _this.$modalIn.find('.modal-title').text('Inventario, Entradas De Productos Metrados'); 
                            _this.referenceMetrado(resp);
                        }else{
                            _this.$modalIn.find('.content-modal').empty().html(_this.templateChooseItemsRollo(resp) );
                            _this.$modalIn.find('.modal-title').text('Inventario, Salidas De Productos Metrados');
                            _this.referenceMetrado(resp);
                        }
                    },
                    'NoSerieNoMetros': function(){
                        if (resp.tipoAjuste == 'E') {
                            _this.collection.trigger('store',resp.data);
                        }else{
                            _this.$modalIn.find('.content-modal').empty().html(_this.templateSeriesLotes(resp));
                            _this.$modalIn.find('.modal-title').text('Inventario, Salidas De Productos ');
                             // Reference inventario
                            _this.referenceNoSerie(resp);
                        }
                    }
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
        /**
        * Reference add Series
        */
        referenceSerie: function(atributes) {
            this.$wraper = this.$('#modal-wrapper-inventario');
            this.$wraperFormIn = this.$modalIn.find('.content-modal');
            this.$wraperDetailIn = this.$modalIn.find('#content-detail-inventory');
            this.$wraperErrorIn = this.$('#error-inventario');

            if(atributes.tipoAjuste == 'E' ){
                this.$wraperSeries = this.$('#browse-series-list');
                for (var i = 1; i <= atributes.data.ajuste2_cantidad_entrada; i++) {
                    this.addOneSerieInventario( new app.ProductoModel({ id: i }) )
                }
                // Hide errors
                this.$wraperErrorIn.hide().empty();
                // Open modal
                this.$modalIn.modal('show');
            }else{
                this.parameters.data = $.extend({}, this.parameters.data);
                this.collection.trigger('store', this.parameters.data);
            }

        },
        /**
        * Reference add No series No metros
        */
        referenceNoSerie: function(atributes) {
            this.$wraper = this.$('#modal-wrapper-inventario');
            this.$wraperFormIn = this.$modalIn.find('.content-modal');
            this.$wraperDetailIn = this.$modalIn.find('#content-detail-inventory');
            this.$wraperErrorIn = this.$('#error-inventario');
            
            this.$wraperSeries = this.$('#browse-series-lotes-list');
            this.LotesProducto.fetch({ reset: true, data: { producto: atributes.data.ajuste2_producto, sucursal: atributes.data.sucursal } });
            // Hide errors
            this.$wraperErrorIn.hide().empty();
            // Open modal
            this.$modalIn.modal('show');
  

        },
      	/**
        * Reference add RolloMetrado
        */
        referenceMetrado: function(atributes) {
            this.$wraper = this.$('#modal-wrapper-inventario');
            this.$wraperFormIn = this.$modalIn.find('.content-modal');
            this.$wraperDetailIn = this.$modalIn.find('#content-detail-inventory');
            this.$wraperErrorIn = this.$('#error-inventario');
            if(atributes.tipoAjuste == 'E' ){
                // Items rollo view
                this.$wraperItemRollo = this.$('#browse-itemtollo-list');
                this.itemRolloINList.add( new app.ItemRolloModel({ id: shortid.uuid() }) );

            }else{
                //salidas
                this.$wraperItemRollo = this.$('#browse-chooseitemtollo-list');
                this.itemRolloINList.fetch({ reset: true, data: { producto: atributes.data.ajuste2_producto, sucursal: atributes.data.sucursal } });
            }
            // Hide errors
            this.$wraperErrorIn.hide().empty();

            // Open modal
            this.$modalIn.modal('show');

        },
        /**
        * Render view task by model
        * @param Object ProductoLote Model instance
        */
        addOneProductoLote: function (ProductoLote) {
            var view = new app.ProductoLotesINListView({
                model: ProductoLote,
            });

            this.$wraperSeries.append( view.render().el );

            this.ready();
            
        },

        /**
        * Render all view tast of the collection
        */
        addAllProductoLote: function () {
            var _this = this; 
            this.LotesProducto.forEach(function(model, index) {
                _this.addOneProductoLote(model)
            });
        },

        /**
        * Render view task by model
        * @param Object Producto Model instance
        */
        addOneSerieInventario: function (ProductoModel) {
            var view = new app.ProductoSeriesINListView({
                model: ProductoModel
            });

            this.$wraperSeries.append( view.render().el );
            this.ready();
        },

        /**
        * Render all view tast of the collection
        */
        addAllItemRolloInventario: function () {
            var _this = this;
            this.itemRolloINList.forEach(function(model, index) {
                _this.addOneItemRolloInventario(model)
            });
        },

        /**
        * Render view task by model
        * @param Object ItemRolloModel Model instance
        */
        addOneItemRolloInventario: function (itemRolloModel) {
            var view = new app.ItemRolloINListView({
                model: itemRolloModel,
                parameters: {
                    type: this.parameters.tipoAjuste
                }
            });

            itemRolloModel.view = view;
            this.$wraperItemRollo.append( view.render().el );
            this.ready();
        },
        /*
        *Validate Carro temporal
        */
        onStoreItemInventario: function (e){
            if (!e.isDefaultPrevented()) {
                e.preventDefault(); 
                if (this.parameters.action == 'modalSerie') {
                    this.parameters.data = $.extend({}, this.parameters.data, window.Misc.formToJson(e.target));
                    this.collection.trigger('store', this.parameters.data);
                
                }else{
                    var items = [];
                    items =  window.Misc.formToJson( e.target );
                    this.parameters.data = $.extend({}, this.parameters.data);
                    this.parameters.data.items =  items;
                    this.collection.trigger('store', this.parameters.data);
                }
            }
        },
        /*
        *changed unidades de salidas
        */
        changedCantidadUnidadesSalida: function(e){
            if (!e.isDefaultPrevented()) {
                e.preventDefault();
                
                if (this.parameters.action == 'ProductoMetrado' ) {
                     // Valid total
                    var ingresadas = 0;
                    var result =_.every(this.itemRolloINList.models, function(itemRolloModel) { 
                        
                        if( itemRolloModel.get('prodboderollo_saldo') < parseFloat( this.$('#item_'+itemRolloModel.get('id')).val() ) ) {
                            alertify.error("Cantidad insuficiente para este item, (" + itemRolloModel.get('prodboderollo_saldo') + ") SALDO, (" + this.$('#item_'+itemRolloModel.get('id')).val() + ") INGRESADAS, por favor verifique información.");
                            return false;
                        }
                        return  true; 
                    });

                }else{

                     // Valid total
                    var ingresadas = 0;
                    var result =_.every(this.LotesProducto.models, function(modelProdbodeLote) { 
                        
                        if( modelProdbodeLote.get('prodbodelote_saldo') < parseFloat( this.$('#item_'+modelProdbodeLote.get('id')).val() ) ) {
                            alertify.error("Cantidad insuficiente para este item, (" + modelProdbodeLote.get('prodbodelote_saldo') + ") SALDO, (" + this.$('#item_'+modelProdbodeLote.get('id')).val() + ") INGRESADAS, por favor verifique información.");
                            return false;
                        }
                        return  true; 
                    });
                }   
            }
        },

        /*
        * Add item unidades de entrada
        */
        clickAddItemRollo: function(e) {
            e.preventDefault();

            // Valid total
            var ingresadas = 0;
            _.each(this.itemRolloINList.models, function(itemRolloModel){  
                ingresadas+= parseFloat( this.$('#itemrollo_metros_'+itemRolloModel.get('id')).val() );
            });

            if(ingresadas >= this.parameters.data.ajuste2_cantidad_entrada) {
                alertify.error("No puede superar la cantidad de metros(" + this.parameters.data.ajuste2_cantidad_entrada +") a ingresar, por favor verifique información.");
                return;
            }
         
            this.itemRolloINList.add( new app.ItemRolloModel({ id: shortid.uuid() }) );
        },

        /*
        * Remove item unidades de entrada
        */
        clickRemoveItemRollo: function(e) {
            e.preventDefault();

            var resource = $(e.currentTarget).attr("data-resource"),
                model = this.itemRolloINList.get(resource);

            if ( model instanceof Backbone.Model ) {
                
                this.itemRolloINList.remove(model);                
                model.view.remove();

            }
        },

        responseServer: function ( model, resp, opts ) {
            if(!_.isUndefined(resp.success)) {
                if( resp.success ) {
                    // Close modals
                    this.$modalIn.modal('hide');
                }
            }
        }

    });
})(jQuery, this, this.document);