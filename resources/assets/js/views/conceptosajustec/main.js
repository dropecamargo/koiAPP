/**
* Class MainConceptoAjustecView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainConceptoAjustecView = Backbone.View.extend({

        el: '#conceptoajustec-main',

        /**
        * Constructor Method
        */
        initialize : function() {

            this.$conceptoajustecSearchTable = this.$('#conceptoajustec-search-table');
            this.$conceptoajustecSearchTable.DataTable({
                dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('conceptosajustec.index') ),
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'conceptoajustec_nombre', name: 'conceptoajustec_nombre' },
                    { data: 'conceptoajustec_activo', name: 'conceptoajustec_activo'}
                ],
                buttons: [
                    {
                        text: '<i class="fa fa-plus"></i> Nuevo concepto de ajuste',
                        className: 'btn-sm',
                        action: function ( e, dt, node, config ) {
                            window.Misc.redirect( window.Misc.urlFull( Route.route('conceptosajustec.create') ) )
                        }
                    }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('conceptosajustec.show', {conceptosajustec: full.id }) )  +'">' + data + '</a>';
                        }
                    },
                    {
                        targets: 2,
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
