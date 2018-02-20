/**
* Class MainPedidosView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainPedidosView = Backbone.View.extend({

        el: '#pedido-main',

        /**
        * Constructor Method
        */
        initialize : function() {

            // Rerefences
            this.$productosSearchTable = this.$('#pedido-search-table');
            this.$productosSearchTable.DataTable({
                dom:"<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('pedidos.index') ),
                columns: [
                    { data: 'pedido1_numero', name: 'pedido1_numero' },
                    { data: 'sucursal_nombre', name: 'sucursal_nombre' },
                    { data: 'tercero_nombre', name: 'tercero_nombre' },
                    { data: 'pedido1_fecha', name: 'pedido1_fecha' },
                    { data: 'tercero_nombre1', name: 'tercero_nombre1' },
                    { data: 'tercero_nombre2', name: 'tercero_nombre2' },
                    { data: 'tercero_nombre2', name: 'tercero_apellido1' },
                    { data: 'tercero_nombre2', name: 'tercero_apellido2' },
                    { data: 'tercero_nit', name: 'tercero_nit' }
                ],
                buttons: [
                    {
                        text: '<i class="fa fa-plus"></i> Nuevo Pedido',
                        className: 'btn-sm',
                        action: function ( e, dt, node, config ) {
                            window.Misc.redirect( window.Misc.urlFull( Route.route('pedidos.create') ) )
                        }
                    }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '25%',
                        render: function ( data, type, full, row ) {
                            if (full.pedido1_cerrado || full.pedido1_anulado) {
                                return '<a href="'+ window.Misc.urlFull( Route.route('pedidos.show', {pedidos: full.id}) )  +'">' + data + ' <span class="label label-warning"> Ver</span></a>';
                            }else{
                                return '<a href="'+ window.Misc.urlFull( Route.route('pedidos.edit', {pedidos: full.id }) )  +'">' + data +' <span class="label label-success"> Abierto</span></a>';
                            }
                        },

                    },
                    {
                        targets:2,
                        searchable:false
                    },
                    {
                        targets:[4,5,6,7,8],
                        visible:false
                    },
                ]
            });
        },

    });
})(jQuery, this, this.document);
