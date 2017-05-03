/**
* Class MainConceptosrcView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainConceptosrcView = Backbone.View.extend({

        el: '#conceptosrc-main',

        /**
        * Constructor Method
        */
        initialize : function() {

            this.$conceptosrcSearchTable = this.$('#conceptosrc-search-table');

            this.$conceptosrcSearchTable.DataTable({
                dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('conceptosrc.index') ),
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'conceptosrc_nombre', name: 'conceptosrc_nombre' },
                    { data: 'plancuentas_nombre', name: 'plancuentas_nombre' },
                    { data: 'documentos_nombre', name: 'documentos_nombre' },
                    { data: 'conceptosrc_activo', name: 'conceptosrc_activo'}
                ],
                buttons: [
                    {
                        text: '<i class="fa fa-plus"></i> Nuevo concepto',
                        className: 'btn-sm',
                        action: function ( e, dt, node, config ) {
                            window.Misc.redirect( window.Misc.urlFull( Route.route('conceptosrc.create') ) )
                        }
                    }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('conceptosrc.show', {conceptosrc: full.id }) )  +'">' + data + '</a>';
                        }
                    },
                    {
                        targets: 4,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return parseInt(data) ? 'Si' : 'No';
                        },
                    }
                ]
            });
        }
    });

})(jQuery, this, this.document);