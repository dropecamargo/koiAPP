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
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            var _this = this;

            // Rerefences
            this.$facturasSearchTable = this.$('#facturas-search-table');
            
            this.$facturasSearchTable.DataTable({
                dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('facturas.index') ),
                columns: [ 
                    { data: 'factura1_numero', name: 'factura1_numero' },
                    { data: 'puntoventa_prefijo', name: 'puntoventa_prefijo' },
                    { data: 'sucursal_nombre', name: 'sucursal_nombre' },
                    { data: 'tercero_nit', name: 'tercero_nit' },
                    { data: 'tercero_nombre', name: 'factura1_tercero' },
                    { data: 'tercero_razonsocial', name: 'tercero_razonsocial'},
                    { data: 'tercero_nombre1', name: 'tercero_nombre1' },
                    { data: 'tercero_nombre2', name: 'tercero_nombre2' },
                    { data: 'tercero_apellido1', name: 'tercero_apellido1' },
                    { data: 'tercero_apellido2', name: 'tercero_apellido2' },
                    { data: 'factura1_fh_elaboro', name: 'factura1_fh_elaboro' },
                ],
                buttons: [
                    {
                        text: '<i class="fa fa-plus"></i> Nueva factura',
                        className: 'btn-sm',
                        action: function ( e, dt, node, config ) {
                            window.Misc.redirect( window.Misc.urlFull( Route.route('facturas.create') ) )
                        }
                    }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '15%',
                        render: function ( data, type, full, row ) {
                           return '<a href="'+ window.Misc.urlFull( Route.route('facturas.show', {facturas: full.id }) )  +'">' + data + '</a>';
                        },
                       
                    },
                    {
                        targets: [5,6,7,8,9],
                        visible: false,
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
        }
    });
})(jQuery, this, this.document);
