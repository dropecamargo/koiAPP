/**
* Class MainPedidoscView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainPedidoscView = Backbone.View.extend({

        el: '#pedidosc-main',
        events: {
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            var _this = this;

            // Rerefences
            this.$ajustesSearchTable = this.$('#pedidosc-search-table');
            
            this.$ajustesSearchTable.DataTable({
                dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('pedidosc.index') ),
                columns: [ 
                    { data: 'id', name: 'id' },
                    { data: 'autorizaca_tercero', name: 'autorizaca_tercero' },
                    { data: 'autorizaca_vencimiento', name: 'autorizaca_vencimiento' },
                    { data: 'autorizaca_plazo', name: 'autorizaca_plazo' },
                ],
                buttons: [
                    {
                        text: '<i class="fa fa-plus"></i> Nuevo pedido',
                        className: 'btn-sm',
                        action: function ( e, dt, node, config ) {
                            window.Misc.redirect( window.Misc.urlFull( Route.route('pedidosc.create') ) )
                        }
                    }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '25%',
                        render: function ( data, type, full, row ) {
                           return '<a href="'+ window.Misc.urlFull( Route.route('pedidosc.show', {pedidosc: full.id }) )  +'">' + data + '</a>';
                        },
                       
                    }, 
                ]
            });
        }
    });
})(jQuery, this, this.document);
