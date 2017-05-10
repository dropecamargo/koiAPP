/**
* Class MainConceptoNotaView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainConceptoNotaView = Backbone.View.extend({

        el: '#conceptonota-main',

        /**
        * Constructor Method
        */
        initialize : function() {
            this.$conceptonotaSearchTable = this.$('#conceptonota-search-table');
            this.$conceptonotaSearchTable.DataTable({
                dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('conceptonotas.index') ),
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'conceptonota_nombre', name: 'conceptonota_nombre' },
                    { data: 'plancuentas_nombre', name: 'plancuentas_nombre' },
                    { data: 'conceptonota_activo', name: 'conceptonota_activo'}
                ],
                buttons: [
                    {
                        text: '<i class="fa fa-plus"></i> Nueva nota',
                        className: 'btn-sm',
                        action: function ( e, dt, node, config ) {
                            window.Misc.redirect( window.Misc.urlFull( Route.route('conceptonotas.create') ) )
                        }
                    }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('conceptonotas.show', {conceptonotas: full.id }) )  +'">' + data + '</a>';
                        }
                    },
                    {
                        targets: 3,
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