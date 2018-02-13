/**
* Class MainConceptoAjustepView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainConceptoAjustepView = Backbone.View.extend({

        el: '#conceptoajustep-main',

        /**
        * Constructor Method
        */
        initialize : function() {

            this.$conceptoajustepSearchTable = this.$('#conceptoajustep-search-table');

            this.$conceptoajustepSearchTable.DataTable({
                dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('conceptosajustep.index') ),
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'conceptoajustep_nombre', name: 'conceptoajustep_nombre' },
                    { data: 'plancuentas_nombre', name: 'plancuentas_nombre' },
                    { data: 'conceptoajustep_activo', name: 'conceptoajustep_activo'}
                ],
                buttons: [
                    {
                        text: '<i class="fa fa-plus"></i> Nuevo concepto',
                        className: 'btn-sm',
                        action: function ( e, dt, node, config ) {
                            window.Misc.redirect( window.Misc.urlFull( Route.route('conceptosajustep.create') ) )
                        }
                    }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('conceptosajustep.show', {conceptosajustep: full.id }) )  +'">' + data + '</a>';
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
