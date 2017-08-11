/**
* Class MainAjustepView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainAjustepView = Backbone.View.extend({

        el: '#ajustesp-main',

        /**
        * Constructor Method
        */
        initialize : function() {
            this.$ajustecSearchTable = this.$('#ajustesp-search-table');

            this.$ajustecSearchTable.DataTable({
                dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('ajustesp.index') ),
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'tercero_nombre', name: 'tercero_nombre' },
                    { data: 'ajustep1_observaciones', name: 'ajustep1_observaciones'}
                ],
                buttons: [
                    {
                        text: '<i class="fa fa-plus"></i> Nuevo ajuste proveedor',
                        className: 'btn-sm',
                        action: function ( e, dt, node, config ) {
                            window.Misc.redirect( window.Misc.urlFull( Route.route('ajustesp.create') ) )
                        }
                    }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('ajustesp.show', {ajustesp: full.id }) )  +'">' + data + '</a>';
                        }
                    }
                ]
            });
        }
    });

})(jQuery, this, this.document);