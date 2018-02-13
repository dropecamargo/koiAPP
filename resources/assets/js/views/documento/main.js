/**
 * Class MainDocumentoView
 * @author KOI || @dropecamargo
 * @link http://koi-ti.com
 */

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainDocumentoView = Backbone.View.extend({
        el: '#documento-main',
        /**
         * Constructor Method
         */
        initialize: function () {

            this.$documentoSearchTable = this.$('#documento-search-table');

            this.$documentoSearchTable.DataTable({
                dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('documento.index') ),
                columns: [
                    { data: 'documentos_codigo', name: 'documentos_codigo' },
                    { data: 'documentos_nombre', name: 'documentos_nombre' }
                ],
                buttons: [
                    {
                        text: '<i class="fa fa-plus"></i> Nuevo documento',
                        className: 'btn-sm',
                        action: function ( e, dt, node, config ) {
                                window.Misc.redirect( window.Misc.urlFull( Route.route('documento.create') ) )
                        }
                    }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('documento.show', {documento: full.id }) )  +'">' + data + '</a>';
                        }
                    },
                    {
                        targets: 1,
                        width: '80%'
                    }
                ]
            });
        }
    });

})(jQuery, this, this.document);
