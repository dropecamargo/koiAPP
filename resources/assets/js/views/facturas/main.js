/**
* Class MainFacturasView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainFacturasView = Backbone.View.extend({

        el: '#facturas-main',

        events: {
            'click .btn-search': 'search',
            'click .btn-clear': 'clear'
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            var _this = this;

            // Rerefences
            this.$searchfacturaNumero = this.$('#searchfactura_numero');
            this.$searchfacturaTercero = this.$('#searchfactura_tercero');
            this.$searchfacturaTerceroNombre = this.$('#searchfactura_tercero_nombre');
            this.$facturasSearchTable = this.$('#facturas-search-table');

            this.facturasSearchTable = this.$facturasSearchTable.DataTable({
                dom:"<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull( Route.route('facturas.index') ),
                    data: function( data ) {
                        data.persistent = true;
                        data.tercero_nit = _this.$searchfacturaTercero.val();
                        data.tercero_nombre = _this.$searchfacturaTerceroNombre.val();
                        data.numero = _this.$searchfacturaNumero.val();
                    }
                },
                columns: [
                    { data: 'factura1_numero', name: 'factura1_numero' },
                    { data: 'puntoventa_prefijo', name: 'puntoventa_prefijo' },
                    { data: 'sucursal_nombre', name: 'sucursal_nombre' },
                    { data: 'tercero_nit', name: 'tercero_nit' },
                    { data: 'tercero_nombre', name: 'factura1_tercero' },
                    { data: 'factura1_fh_elaboro', name: 'factura1_fh_elaboro' },
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                           return '<a href="'+ window.Misc.urlFull( Route.route('facturas.show', {facturas: full.id }) )  +'">' + data + '</a>';
                        },

                    },
                    {
                        targets:2,
                        width:'20%'
                    },
                ],
                fnRowCallback: function( row, data ) {
                    if ( data.factura1_anulada == 1 ) {
                        $(row).css( {"color":"red"} );
                    }else{
                        $(row).css( {"color":"green"} );
                    }
                }
            });
        },

        search: function(e) {
            e.preventDefault();
            this.facturasSearchTable.ajax.reload();
        },

        clear: function(e) {
            e.preventDefault();
            this.$searchfacturaNumero.val('');
            this.$searchfacturaTercero.val('');
            this.$searchfacturaTerceroNombre.val('');

            this.facturasSearchTable.ajax.reload();
        }
    });
})(jQuery, this, this.document);
