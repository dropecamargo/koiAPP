/**
* Class ComponentSearchPedidocView of Backbone
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ComponentSearchPedidocView = Backbone.View.extend({

      	el: 'body',
        template: _.template( ($('#koi-search-pedidoc-component-tpl').html() || '') ),

		events: {
            'change input.tercero-factura-change-koi': 'searchPedidoc',
            'click .btn-search-koi-search-pedidoc-component': 'search',
            'click .btn-clear-koi-search-pedidoc-component': 'clear',
         	'click .a-koi-search-pedidoc-component-table': 'setPedidoc'
		},

        /**
        * Constructor Method
        */
		initialize: function() {
			// Initialize
            this.$modalComponent = this.$('#modal-search-pedidoc-component');
        },

        searchPedidoc: function(e) {
            e.preventDefault();
            var _this = this;
            // Render template
            this.$modalComponent.find('.content-modal').html( this.template({ }) );

            // References
            this.$searchNumeroPedidoc = this.$('#koi_search_pedidoc_numero');
            this.$searchSucursalPedidoc = this.$('#koi_search_pedidoc_sucursal');

            this.$pedidoscSearchTable = this.$modalComponent.find('#koi-search-pedidoc-component-table');

            this.$inputContent = this.$("#"+$(e.currentTarget).attr("id"));
            this.$pago = this.$("#"+$(e.currentTarget).attr("data-formapago"));
            this.$plazo = this.$("#"+$(e.currentTarget).attr("data-plazo"));
            this.$cuotas = this.$("#"+$(e.currentTarget).attr("data-cuotas"));
            this.$primerpago = this.$("#"+$(e.currentTarget).attr("data-primerpago"));
            this.$tname = this.$("#"+$(e.currentTarget).attr("data-nameTC"));
            this.$taddress = this.$("#"+$(e.currentTarget).attr("data-dirTC"));
            this.$sucursal = this.$("#"+$(e.currentTarget).attr("data-sucursalP"));
            this.$vendedor = this.$("#"+$(e.currentTarget).attr("data-vendedorT"));
            this.$observaciones = this.$("#"+$(e.currentTarget).attr("data-obs"));
            this.$dataChange = this.$inputContent.attr("data-change");

            var tercero = this.$inputContent.val();

            this.pedidoscSearchTable = this.$pedidoscSearchTable.DataTable({
                dom: "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull( Route.route('pedidosc.index') ),
                    data: function( data ) {
                        data.pedidoc1_numero = _this.$searchNumeroPedidoc.val();
                        data.pedidoc1_sucursal = _this.$searchSucursalPedidoc.val();
                        data.tercero = tercero;
                    }
                },
                columns: [
                    { data: 'pedidoc1_numero', name: 'pedidoc1_numero' },
                    { data: 'sucursal_nombre', name: 'sucursal_nombre'},
                    { data: 'pedidoc1_fecha', name: 'pedidoc1_fecha' }, 
                    { data: 'vendedor_nombre', name: 'vendedor_nombre' },
                ],
                columnDefs: [
					{
						targets: 0,
						searchable: false,
						render: function ( data, type, full, row ) {
							return '<a href="#" class="a-koi-search-pedidoc-component-table">' + data + '</a>';
						}
					}
					
                ]
			});

            // Modal show
            this.ready();
			this.$modalComponent.modal('show');

            if(this.$modalComponent.length > 0){
                setTimeout( function () { _this.$el.addClass('modal-open') }, 500);
            }
		},

		setPedidoc: function(e) {
			e.preventDefault();
	        var data = this.pedidoscSearchTable.row( $(e.currentTarget).parents('tr') ).data();

            if (this.$dataChange == "true") {
                var select2 = [{id: data.pedidoc1_sucursal , text: data.sucursal_nombre}];
                    select2Vendedor = [{id: data.pedidoc1_vendedor , text: data.vendedor_nombre}];
                this.$plazo.val( data.pedidoc1_plazo );
                this.$cuotas.val( data.pedidoc1_cuotas );
                (this.$cuotas.val()==0) ? this.$pago.val('CONTADO'): this.$pago.val('CREDITO') ;
                this.$primerpago.val( data.pedidoc1_primerpago );
                this.$tname.val( data.tcontacto_nombre );
                this.$taddress.val( data.tcontacto_direccion );
                this.$observaciones.val(data.pedidoc1_observaciones);
                this.$sucursal.select2({ data: select2 });
                this.$vendedor.select2({data: select2Vendedor });
            }
			this.$modalComponent.modal('hide');
		},

		search: function(e) {
			e.preventDefault();

		    this.pedidoscSearchTable.ajax.reload();
		},

		clear: function(e) {
			e.preventDefault();

            this.$searchSerie.val('');
            this.$searchNombre.val('');

            this.pedidoscSearchTable.ajax.reload();
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