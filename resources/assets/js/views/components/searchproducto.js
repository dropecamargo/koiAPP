/**
* Class ComponentSearchProductoView of Backbone
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ComponentSearchProductoView = Backbone.View.extend({

      	el: 'body',
        template: _.template( ($('#koi-search-producto-component-tpl').html() || '') ),

		events: {
			'change input.producto-koi-component': 'productoChanged',
            'click .btn-koi-search-producto-component': 'searchProducto',
            'click .btn-search-koi-search-producto-component': 'search',
            'click .btn-clear-koi-search-producto-component': 'clear',
            'click .a-koi-search-producto-component-table': 'setProducto'
		},

        /**
        * Constructor Method
        */
		initialize: function() {
			// Initialize
            this.$modalComponent = this.$('#modal-search-producto-component');
		},

		searchProducto: function(e) {
            e.preventDefault();
            var _this = this;

            // Render template
            this.$modalComponent.find('.content-modal').html( this.template({ }) );

            // References
            this.$searchReferencia = this.$('#koi_search_producto_referencia');
            this.$searchSerie = this.$('#koi_search_producto_serie');
            this.$searchNombre = this.$('#koi_search_producto_nombre');

            this.$productosSearchTable = this.$modalComponent.find('#koi-search-producto-component-table');
			this.$inputContent = this.$("#"+$(e.currentTarget).attr("data-field"));
			this.$inputName = this.$("#"+this.$inputContent.attr("data-name"));
			this.$inputCosto = this.$("#"+this.$inputContent.attr("data-costo"));
			this.$inputPrecio1 = this.$("#"+this.$inputContent.attr("data-price"));			
			this.$inputSucursal = this.$("#"+this.$inputContent.attr("data-office"));
			this.$remision = this.$inputContent.attr("data-remision");
			this.$orden = this.$inputContent.attr("data-orden");
			this.$sucursal = this.$inputContent.attr("data-sucursal");
			
			// remove for add item in factura orden
			if (! _.isUndefined( this.$inputName.attr('data-id') ) ) 
				this.$inputName.removeAttr('data-id');
			// Filters
			this.$equalsRef = this.$inputContent.attr("data-ref");
			if((this.$equalsRef == "true" || this.$equalsRef == "false") && this.$inputSucursal.val() == '' ){
				alertify.error('Por favor ingrese sucursal antes agregar producto.');
                return;
			}
			this.productosSearchTable = this.$productosSearchTable.DataTable({
				dom: "<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull( Route.route('productos.index') ),
                    data: function( data ) {
                        data.producto_serie = _this.$searchSerie.val();
                        data.producto_nombre = _this.$searchNombre.val();
                        data.producto_referencia = _this.$searchReferencia.val();
                        data.equalsRef = _this.$equalsRef;
                        data.remision = _this.$remision;
                        data.orden = _this.$orden;
                        data.sucursal = _this.$sucursal;
                        data.officeSucursal = _this.$inputSucursal.val();
                    }
                },
                columns: [
                    { data: 'producto_referencia', name: 'producto_referencia'},
                    { data: 'producto_serie', name: 'producto_serie' },
                    { data: 'producto_nombre', name: 'producto_nombre' }, 
                ],
                columnDefs: [
					{
						targets: 0,
						width: '10%',
						searchable: false,
						render: function ( data, type, full, row ) {
							return '<a href="#" class="a-koi-search-producto-component-table">' + data + '</a>';
						}
					}
					
                ]
			});

            // Modal show
            this.ready();
			this.$modalComponent.modal('show');
		},

		setProducto: function(e) {
			e.preventDefault();
	        var data = this.productosSearchTable.row( $(e.currentTarget).parents('tr') ).data();
			this.$inputContent.val( data.producto_serie );
			this.$inputName.val( data.producto_nombre );
			(!_.isUndefined( this.$inputCosto )) ? this.$inputCosto.val(window.Misc.currency(data.producto_costo)) : '';
			
			if (! _.isUndefined(this.$inputPrecio1)) {
				this.$inputPrecio1.val(window.Misc.currency(data.producto_precio1));
				this.$('#pedidoc2_iva_porcentaje').val(data.impuesto_porcentaje) ;
				this.$('#remrepu2_iva_porcentaje').val(data.impuesto_porcentaje) ;
			}
			if(!_.isUndefined(data.producto_maneja_serie) && data.producto_maneja_serie == 1){
				this.$('#ajuste2_cantidad_salida').val(1).prop('readonly' , true);
				this.$('#traslado2_cantidad').val(1).prop('readonly' , true);
			}else{
				this.$('#ajuste2_cantidad_salida').val('').prop('readonly' , false);
				this.$('#traslado2_cantidad').val('').prop('readonly' , false);
			}
			this.$modalComponent.modal('hide');
		},

		search: function(e) {
			e.preventDefault();

		    this.productosSearchTable.ajax.reload();
		},

		clear: function(e) {
			e.preventDefault();

            this.$searchSerie.val('');
            this.$searchNombre.val('');

            this.productosSearchTable.ajax.reload();
		},

		productoChanged: function(e) {
			var _this = this;

			this.$inputContent = $(e.currentTarget);
			this.$inputName = this.$("#"+$(e.currentTarget).attr("data-name"));
			this.$inputCosto = this.$("#"+$(e.currentTarget).attr("data-costo"));
			this.$wraperConten = this.$("#"+$(e.currentTarget).attr("data-wrapper"));
			this.$inputPrecio1 = this.$("#"+this.$inputContent.attr("data-price"));			
        	this.equalsRef = this.$inputContent.attr("data-ref");

			if(this.equalsRef == "true" && this.$('#ajuste1_sucursal').val() == '' ){
				alertify.error('Por favor ingrese sucursal antes agregar producto.');
                return;
			}
			
			var producto = this.$inputContent.val();

            // Before eval clear data
            this.$inputName.val('');
            this.$inputCosto.val('');

			if(!_.isUndefined(producto) && !_.isNull(producto) && producto != '') {
				// Get Producto
	            $.ajax({
	                url: window.Misc.urlFull(Route.route('productos.search')),
	                type: 'GET',
	                data: { producto_serie: producto },
	                beforeSend: function() {
						_this.$inputName.val('');
						_this.$inputCosto.val('');
	                    window.Misc.setSpinner( _this.$wraperConten );
	                }
	            })
	            .done(function(resp) {
	                window.Misc.removeSpinner( _this.$wraperConten );
	                
	                if(resp.success) {
	                    if(!_.isUndefined(resp.producto_nombre) && !_.isNull(resp.producto_nombre)){
							_this.$inputName.val(resp.producto_nombre);
	                    }	
	                    if(!_.isUndefined(resp.producto_costo) && !_.isNull(resp.producto_costo)){
							_this.$inputCosto.val(window.Misc.currency(resp.producto_costo));
	                    }
	                    if(!_.isUndefined(resp.producto_precio1) && !_.isNull(resp.producto_precio1)){
							_this.$inputPrecio1.val(window.Misc.currency(resp.producto_precio1));
							_this.$('#pedidoc2_iva_porcentaje').val(resp.impuesto_porcentaje);
	                    }	                   
	                }
	            })
	            .fail(function(jqXHR, ajaxOptions, thrownError) {
	                window.Misc.removeSpinner( _this.$wraperConten );
	                alertify.error(thrownError);
	            });
	     	}
		},

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();
        }
    });


})(jQuery, this, this.document);
