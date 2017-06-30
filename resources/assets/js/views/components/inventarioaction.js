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

        templateAddISerieFactu: _.template( ($('#add-series-factu-tpl').html() || '') ),

        templateChooseItemsRollo: _.template( ($('#choose-itemrollo-tpl').html() || '') ),
        templateAddItemsProductVence: _.template( ($('#product-vence-tpl').html() || '') ),
        templateChooseItemsProductVence: _.template( ($('#product-choose-vence-tpl').html() || '') ),

    	events:{ 
            'submit #form-create-inventario-entrada-component-source': 'onStoreItemInventario',
            'change .cantidad-salidau-koi-inventario': 'changedCantidadUnidadesSalida',
            'click #btn-itemrollo-entradau-koi-inventario': 'clickAddItemRollo',
            'click .btn-remove-itemrollo-koi-inventario': 'clickRemoveItemRollo',
            'click #btn-vencimiento-entradau-koi-inventario': 'clickAddVencimiento',
            'click .btn-remove-itemvencimiento-koi-inventario': 'clickRemoveItemVencimiento',
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
            // Collection prodbode
            this.prodbodeList = new app.ProdbodeList();

            // Events Listeners
            this.listenTo( this.LotesProducto, 'reset', this.addAllProductoLote );
            this.listenTo( this.LotesProducto, 'add', this.addOneVencimientoInventario );

            this.listenTo( this.itemRolloINList, 'add', this.addOneItemRolloInventario );
            this.listenTo( this.itemRolloINList, 'reset', this.addAllItemRolloInventario );

            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.collection, 'sync', this.responseServer );
            this.ready();
        },

        /*
        * Render View Element
        */
        render: function() {
            var resp = this.parameters,
                _this = this,
                stuffToDo = {
                    'modalSerie': function() {
                        if (resp.tipo == 'E') {
                            _this.$modalIn.find('.content-modal').empty().html(_this.templateAddSeries( ));
                            _this.$modalIn.find('.modal-title').text('Inventario, Entradas De Productos ');

                            // Reference inventario
                            _this.referenceSerie(resp);
                        }else{
                            // Reference inventario
                            _this.referenceSerie(resp);
                        }

                    },
                    'ProductoMetrado': function(){
                        if (resp.tipo  == 'E') {
                            _this.$modalIn.find('.content-modal').empty().html(_this.templateAddItemRollo(resp) );
                            _this.$modalIn.find('.modal-title').text('Inventario - Entradas de productos metrados'); 
                            _this.referenceMetrado(resp);
                        }else{
                            _this.$modalIn.find('.content-modal').empty().html(_this.templateChooseItemsRollo(resp) );
                            _this.$modalIn.find('.modal-title').text('Inventario - Salidas de productos metrados');
                            _this.referenceMetrado(resp);
                        }
                    },
                    'ProductoVence': function(){
                        if (resp.tipo  == 'E') {
                            _this.$modalIn.find('.content-modal').empty().html(_this.templateAddItemsProductVence(resp) );
                            _this.$modalIn.find('.modal-title').text('Inventario - Entradas de productos con fecha de vencimiento '); 
                            _this.referenceVencimiento(resp);
                        }
                        else{
                            _this.$modalIn.find('.content-modal').empty().html(_this.templateChooseItemsProductVence(resp) );
                            _this.$modalIn.find('.modal-title').text('Inventario - Salida de productos con fecha de vencimiento');
                            _this.referenceVencimiento(resp);
                        }
                    },
                    'NoSerieNoMetros': function(){
                        if (resp.tipo == 'E') {
                            _this.collection.trigger('store',resp.data);
                        }else{
                            _this.$modalIn.find('.content-modal').empty().html(_this.templateSeriesLotes(resp));
                            _this.$modalIn.find('.modal-title').text('Inventario - Salidas de productos ');

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
            this.$wraperErrorIn = this.$('#error-inventario');

            if(atributes.tipo == 'E' ){
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
            this.$wraperErrorIn = this.$('#error-inventario');
            
            this.$wraperSeries = this.$('#browse-series-lotes-list');
            this.LotesProducto.fetch({ reset: true, data: { producto: atributes.data.producto_serie, sucursal: atributes.data.sucursal } });

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
            this.$wraperErrorIn = this.$('#error-inventario');

            if(atributes.tipo == 'E' ){
                // Items rollo view
                this.$wraperItemRollo = this.$('#browse-itemtollo-list');
                this.itemRolloINList.add( new app.ItemRolloModel({ id: shortid.uuid() }) );

            }else{
                //salidas
                this.$wraperItemRollo = this.$('#browse-chooseitemtollo-list');
                this.itemRolloINList.fetch({ reset: true, data: { producto: atributes.data.producto_serie,   sucursal: atributes.data.sucursal } });
            }

            // Hide errors
            this.$wraperErrorIn.hide().empty();

            // Open modal
            this.$modalIn.modal('show');

        },
        /**
        *Reference add fecha lote vencimiento
        */
        referenceVencimiento: function(atributes){
            this.$wraper = this.$('#modal-wrapper-inventario');
            this.$wraperFormIn = this.$modalIn.find('.content-modal');
            this.$wraperErrorIn = this.$('#error-inventario');

            if(atributes.tipo == 'E' ){
                // Items vence view
                this.$wraperVence = this.$('#browse-product-vence-list');
                this.LotesProducto.add( new app.LoteModel({ id: shortid.uuid() }) );
             }else{
                //salidas
                this.$wraperSeries = this.$('#browse-chooseproduct-vence-list');
                this.LotesProducto.fetch({reset: true, data: { producto: atributes.data.producto_serie, sucursal: atributes.data.sucursal } } );

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
        * Render view task by model
        * @param Object Producto Model instance
        */
        addOneVencimientoInventario: function (productoModel) {
            // prepare lote encabezado
            productoModel.set({lote_numero: this.parameters.data.lote});

            var view = new app.ProductoVenceINListView({
                model: productoModel,
                parameters:{
                    type: this.parameters.tipo
                }
            });
            
            productoModel.view = view;
            this.$wraperVence.append( view.render().el );
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
            // prepare lote encabezado
            itemRolloModel.set({rollo_lote: this.parameters.data.lote});

            var view = new app.ItemRolloINListView({
                model: itemRolloModel,
                parameters: {
                    type: this.parameters.tipo
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

                }else if(this.parameters.action == 'ProductoMetrado' && this.parameters.tipo == 'E') {
                    var metros = 0,
                        cantidad = 0;

                    //Prepare and setter models of collection
                    _.each(this.itemRolloINList.models,function(model){
                        metros = this.$('#itemrollo_metros_'+ model.get('id')).val();
                        cantidad = this.$('#rollos_'+ model.get('id')).val();
                        model.set({rollo_metros: metros , rollo_cantidad: cantidad });
                    });
                    this.parameters.data = $.extend({}, this.parameters.data);
                    this.parameters.data.items = this.itemRolloINList;
                    this.collection.trigger('store', this.parameters.data);

                }else if(this.parameters.action == 'ProductoVence' && this.parameters.tipo == 'E'){
                    var lote = 0,
                        unidades = 0;
                        fecha = 0;

                    //Prepare and setter models of collection
                    _.each(this.LotesProducto.models,function(model){
                        lote = this.$('#prodbodevence_lote_'+ model.get('id')).val();
                        unidades = this.$('#prodbodevence_unidades_'+ model.get('id')).val();
                        fecha = this.$('#prodbodevence_fecha_'+ model.get('id')).val();
                        model.set({lote_numero: lote , lote_cantidad: unidades, lote_fecha: fecha });
                    });
                    this.parameters.data = $.extend({}, this.parameters.data);
                    this.parameters.data.items = this.LotesProducto;
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
                        if( itemRolloModel.get('rollo_saldo') < parseFloat( this.$('#item_'+itemRolloModel.get('id')).val() ) ) {
                            alertify.error("Cantidad insuficiente para este item, (" + itemRolloModel.get('rollo_saldo') + ") SALDO, (" + this.$('#item_'+itemRolloModel.get('id')).val() + ") INGRESADAS, por favor verifique información.");
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
                ingresadas+= parseFloat( this.$('#itemrollo_metros_'+itemRolloModel.get('id')).val() * this.$('#rollos_'+itemRolloModel.get('id')).val() );
            });
            
            if(ingresadas >= this.parameters.data.ajuste2_cantidad_entrada) {
                alertify.error("No puede superar la cantidad de metros(" + this.parameters.data.ajuste2_cantidad_entrada +") a ingresar, por favor verifique información.");
                return;
            }
         
            this.itemRolloINList.add( new app.ItemRolloModel({ id: shortid.uuid() }) );
        },
        /*
        *Add item unidades de entrada productos que vencen
        */
        clickAddVencimiento: function(e){
            e.preventDefault();
            // Valid total
            var unidades = 0;
            _.each(this.LotesProducto.models, function(productVencenModel){ 
                unidades+= parseFloat( this.$('#prodbodevence_unidades_'+productVencenModel.get('id')).val());
            });
            
            if(unidades >= this.parameters.data.ajuste2_cantidad_entrada) {
                alertify.error("No puede superar la cantidad de unidades(" + this.parameters.data.ajuste2_cantidad_entrada +") a ingresar, por favor verifique información.");
                return;
            }
         
            this.LotesProducto.add( new app.LoteModel({ id: shortid.uuid() }) );
        },
        /*
        * Remove item unidades de entrada
        */
        clickRemoveItemVencimiento: function(e) {
            e.preventDefault();

            var resource = $(e.currentTarget).attr("data-resource"),
                model = this.LotesProducto.get(resource);

            if ( model instanceof Backbone.Model ) {
                this.LotesProducto.remove(model);                
                model.view.remove();
            }
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

                    // Clear Form of car temp
                    if (!_.isUndefined(this.parameters.form)) 
                        window.Misc.clearForm(this.parameters.form);
                }
            }
        }

    });
})(jQuery, this, this.document);