/**
* Class ComponentSearchFacturaView of Backbone
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ComponentSearchFacturaView = Backbone.View.extend({

        el: 'body',
        template: _.template( ($('#koi-search-producto-component-tpl').html() || '') ),

        events: {
            'change input.factura-koi-component': 'FacturaChanged',
            // 'click .btn-koi-search-producto-component': 'searchProducto',
            // 'click .btn-search-koi-search-producto-component': 'search',
            // 'click .btn-clear-koi-search-producto-component': 'clear',
            // 'click .a-koi-search-producto-component-table': 'setProducto'
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

        FacturaChanged: function(e) {
            var _this = this;
            this.$inputContent = $(e.currentTarget);
            this.$wraperConten = this.$("#"+$(e.currentTarget).attr("data-wrapper"));
            this.$inputSucursal = this.$("#"+$(e.currentTarget).attr("data-sucursal"));       
            this.$inputName = this.$("#"+$(e.currentTarget).attr("data-name"));       
            this.$inputNit = this.$("#"+$(e.currentTarget).attr("data-nit"));       
   
            var factura = this.$inputContent.val();
                sucursal = this.$inputSucursal.val();

            if ( sucursal == '' ) {
                this.$inputContent.val('');
                alertify.error('Por favor seleccione sucursal antes de buscar una factura');
                return;
            }
            if(!_.isUndefined(factura) && !_.isNull(factura) && factura != '') {
                // Get Producto
                $.ajax({
                    url: window.Misc.urlFull(Route.route('facturas.search')),
                    type: 'GET',
                    data: { factura_numero: factura,
                            factura_sucursal:sucursal },
                    beforeSend: function() {
                        window.Misc.setSpinner( _this.$wraperConten );
                    }
                })
                .done(function(resp) {
                    window.Misc.removeSpinner( _this.$wraperConten );
                    
                    if(resp.success) {
                        if(!_.isUndefined(resp.cliente) && !_.isNull(resp.cliente)){
                            _this.$inputName.val(resp.cliente);
                        }   
                        if(!_.isUndefined(resp.nit) && !_.isNull(resp.nit)){
                            _this.$inputNit.val(resp.nit);
                        }
                        _this.$inputNit .trigger('change',[resp.id]);
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
