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
        events: {
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            var _this = this;

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
              
                    { data: 'id', name: 'id' },
                    { data: 'pedido1_tercero', name: 'pedido1_tercero' },
                    { data: 'pedido1_fecha', name: 'pedido1_fecha' }
                ],
                buttons: [
                    {
                        text: '<i class="fa fa-user-plus"></i> Nuevo Pedido',
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
                            return '<a href="'+ window.Misc.urlFull( Route.route('pedidos.show', {pedidos: full.id }) )  +'">' + data + '</a>';
                        },
                       
                    }
                ]
            });
        },

    });

})(jQuery, this, this.document);
