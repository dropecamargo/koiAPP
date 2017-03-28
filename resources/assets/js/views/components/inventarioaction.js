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
                            _this.$modalIn.find('.content-modal').empty().html(_this.templateAddSeries());
                            _this.$modalIn.find('.modal-title').text('Inventario, Entradas De Productos ');
                            // Reference inventario
                            _this.referenceSerie(resp);
                        }else{
                            _this.$modalIn.find('.content-modal').empty().html(_this.templateSeriesLotes());
                            _this.$modalIn.find('.modal-title').text('Inventario, Salidas De Productos ');
                            // Reference inventario
                            _this.referenceSerie(resp);
                        }

                    },
                    
                    'ProductoMetrado': function(){
                        if (resp.tipoAjuste == 'E') {
                            _this.$modalIn.find('.content-modal').empty().html(_this.templateAddItemRollo( ) );
                            _this.$modalIn.find('.modal-title').text('Inventario, Entradas De Productos Metrados');    
                            _this.ReferenceMetrado(resp);
                        }else{
                            _this.$modalIn.find('.content-modal').empty().html(_this.templateChooseItemsRollo( ) );
                            _this.$modalIn.find('.modal-title').text('Inventario, Salidas De Productos Metrados');
                            _this.ReferenceMetrado(resp);
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
            }else{
                //salidas
                this.$wraperSeries = this.$('#browse-series-lotes-list');
                this.LotesProducto.fetch({ reset: true, data: { producto: atributes.data.ajuste2_producto, sucursal: atributes.data.sucursal } });
            }
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
                for (var i = 1; i <= atributes.data.ajuste2_cantidad_entrada; i++) {
                    this.addOneItemRolloInventario( new app.ItemRolloModel({ id: i }) )
                }
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
                this.parameters.data = $.extend({}, this.parameters.data, window.Misc.formToJson( e.target ));
                var result = this.collection.trigger('store', this.parameters.data);
                // this.$modalIn.modal('hide');   
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