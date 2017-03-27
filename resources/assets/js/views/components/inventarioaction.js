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
                        _this.$modalIn.find('.content-modal').empty().html(_this.templateAddSeries(resp));
                        // Reference inventario
                        _this.referenceSerie(resp);
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
            this.$wraperSeries = this.$('#browse-series-list');

            if(atributes.tipoAjuste == 'E' ){
                for (var i = 1; i <= atributes.data.ajuste2_cantidad_entrada; i++) {
                    this.addOneSerieInventario( new app.ProductoModel({ id: i }) )
                }
            }else{
                //salidas
                this.LotesProducto.fetch({ reset: true, data: { producto: atributes.data.ajuste2_producto, sucursal: atributes.data.sucursal } });
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