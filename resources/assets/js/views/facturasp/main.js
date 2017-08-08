/**
* Class MainFacturaspView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainFacturaspView = Backbone.View.extend({

        el: '#facturasp-main',

        events: {
            'click .btn-search': 'search',
            'click .btn-clear': 'clear'
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            var _this = this;

            // References
            this.$facturaspSearchTable = this.$('#facturasp-search-table');
            this.$searchfacturapFactura = this.$('#searchfacturap_factura');
            this.$searchfacturapTercero = this.$('#searchfacturap_tercero');
            this.$searchfacturapTerceroNombre = this.$('#searchfacturap_tercero_nombre');
            this.$searchfacturapFecha = this.$('#searchfacturap_fecha');
            
            this.facturaspSearchTable = this.$facturaspSearchTable.DataTable({
                dom: "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull( Route.route('facturasp.index') ),
                    data: function( data ) {
                        data.persistent = true;
                        data.factura = _this.$searchfacturapFactura.val();
                        data.facturap_fecha = _this.$searchfacturapFecha.val();
                        data.tercero_nit = _this.$searchfacturapTercero.val();
                        data.tercero_nombre = _this.$searchfacturapTerceroNombre.val();
                    }
                },
                columns: [ 
                    { data: 'id', name: 'id'},
                    { data: 'tercero_nombre', name: 'tercero_nombre' },
                    { data: 'regional_nombre', name: 'regional_nombre' },
                    { data: 'facturap1_factura', name: 'facturap1_factura' },
                    { data: 'facturap1_fecha', name: 'facturap1_fecha' },
                ],
                columnDefs: [
                    {
                        targets: 0,
                        searchable: false,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                           return '<a href="'+ window.Misc.urlFull( Route.route('facturasp.show', {facturasp: full.id }) )  +'">' + data + '</a>';
                        },
                       
                    }, 
                ]
            });
        }, 

        search: function(e) {
            e.preventDefault();

            this.facturaspSearchTable.ajax.reload();
        },

        clear: function(e) {
            e.preventDefault();

            this.$searchfacturapFactura.val('');
            this.$searchfacturapFecha.val('');
            this.$searchfacturapTercero.val('');
            this.$searchfacturapTerceroNombre.val('');

            this.facturaspSearchTable.ajax.reload();
        },
    });
})(jQuery, this, this.document);
