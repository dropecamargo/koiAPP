/**
* Class MainAjustecView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainAjustecView = Backbone.View.extend({

        el: '#ajustesc-main',

        /**
        * Constructor Method
        */
        initialize : function() {
            this.$ajustecSearchTable = this.$('#ajustesc-search-table');

            this.$ajustecSearchTable.DataTable({
                dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('ajustesc.index') ),
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'tercero_nombre', name: 'tercero_nombre' },
                    { data: 'ajustec1_observaciones', name: 'ajustec1_observaciones'}
                ],
                buttons: [
                    {
                        text: '<i class="fa fa-plus"></i> Nuevo ajuste',
                        className: 'btn-sm',
                        action: function ( e, dt, node, config ) {
                            window.Misc.redirect( window.Misc.urlFull( Route.route('ajustesc.create') ) )
                        }
                    }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('ajustesc.show', {ajustesc: full.id }) )  +'">' + data + '</a>';
                        }
                    }
                ]
            });
        }
    });

})(jQuery, this, this.document);