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
            'change .cantidad-entradau-koi-inventario': 'changedCantidadUnidadesEntrada',
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
            this.$numModel = 1;
            // Collection item rollo
            this.itemRolloINList = new app.ItemRolloINList();
            //Collectio lotes
            this.LotesProducto = new app.ProductoLote();
            // Collection series producto
            this.productoSeriesINList = new app.ProductoSeriesINList();

            // Events Listeners
            this.listenTo( this.LotesProducto, 'reset', this.addAllProductoLote );
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
                            _this.referenceSerie(resp);
                        }

                    },
                    
                    'ProductoMetrado': function(){
                        if (resp.tipoAjuste == 'E') {
                            _this.$modalIn.find('.content-modal').empty().html(_this.templateAddItemRollo(resp) );
                            _this.$modalIn.find('.modal-title').text('Inventario, Entradas De Productos Metrados');    
                            _this.ReferenceMetrado(resp);
                        }else{
                            _this.$modalIn.find('.content-modal').empty().html(_this.templateChooseItemsRollo(resp) );
                            _this.$modalIn.find('.modal-title').text('Inventario, Salidas De Productos Metrados');
                            _this.ReferenceMetrado(resp);
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
            this.parameters.data.lote = this.LotesProducto;
            // Hide errors
            this.$wraperErrorIn.hide().empty();
            // Open modal
            this.$modalIn.modal('show');
  

        },
      	/**
        * Reference add RolloMetrado
        */
        ReferenceMetrado: function(atributes) {
            this.$wraper = this.$('#modal-wrapper-inventario');
            this.$wraperFormIn = this.$modalIn.find('.content-modal');
            this.$wraperDetailIn = this.$modalIn.find('#content-detail-inventory');
            this.$wraperErrorIn = this.$('#error-inventario');
            if(atributes.tipoAjuste == 'E' ){
                // Items rollo view
                this.$wraperItemRollo = this.$('#browse-itemtollo-list');
                this.addOneItemRolloInventario( new app.ItemRolloModel({ id: this.$numModel }) );

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
                _this.addOneItemRolloInventario(model, true)
            });
        },

        /**
        * Render view task by model
        * @param Object ItemRolloModel Model instance
        */
        addOneItemRolloInventario: function (ItemRolloModel, choose) {
            choose || (choose = false);

            var view = new app.ItemRolloINListView({
                model: ItemRolloModel,
                parameters: {
                    choose: choose

                }
            });

            this.$wraperItemRollo.append( view.render().el );

            this.ready();
        },
        /*
        *Validate Carro temporal
        */
        onStoreItemInventario: function (e){
            if (!e.isDefaultPrevented()) {
                e.preventDefault(); 
                var items = [];
                items =  window.Misc.formToJson( e.target );
                this.parameters.data = $.extend({}, this.parameters.data);
                this.parameters.data.items =  items;

                this.collection.trigger('store', this.parameters.data);
            }
        },
        /*
        *changed unidades de salidas
        */
        changedCantidadUnidadesSalida: function(e){
            if (!e.isDefaultPrevented()) {
                e.preventDefault();
                var totalSalida = (parseFloat(this.$('#ajuste2_cantidad_salida').val())).toFixed(2);

                _.each(this.itemRolloINList.models, function(modelProdbodeRollo){
                    
                    totalSalida-=parseFloat(this.$('#item_'+modelProdbodeRollo.get('id')).val()).toFixed(2);

                    if( this.$('#item_'+modelProdbodeRollo.get('id')).val() > modelProdbodeRollo.get('prodboderollo_saldo') ){
                        alertify.error('Saldo en este LOTE es insuficiente');
                        // this.$('#item_'+modelProdbodeRollo.get('id')).attr("readonly", true);
                    }
                    // this.$('#item_'+modelProdbodeRollo.get('id')).attr("readonly", false);
                    if(totalSalida == 0){
                        if(this.$('#item_'+modelProdbodeRollo.get('id')).val() == 0){
                            this.$('#item_'+modelProdbodeRollo.get()).attr("readonly", true);
                        }
                    }
                });
                totalSalida += " (m)";
                this.$('#cantidad-salidau').html(totalSalida);
            }
        },
        /*
        *changed unidades de entrada
        */
        changedCantidadUnidadesEntrada: function(e){
            if (!e.isDefaultPrevented()) {
                e.preventDefault();
                this.$numModel = this.$numModel + 1;
                var totalEntrada = (parseFloat(this.$('#cantidad-entradau').html()) - this.$(e.currentTarget).val()).toFixed(2);
                if (totalEntrada > 0) {
                    totalEntrada += " (m)";
                    this.$('#cantidad-entradau').html(totalEntrada);
                    this.addOneItemRolloInventario( new app.ItemRolloModel({ id: this.$numModel }) );
                }else if(totalEntrada == 0){
                    totalEntrada += " (m)";
                    this.$('#cantidad-entradau').html(totalEntrada);
                }else{
                    alertify.error("Ha sobrepasado la cantidad de metraje a ingresar, por favor verifique información");
                }
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