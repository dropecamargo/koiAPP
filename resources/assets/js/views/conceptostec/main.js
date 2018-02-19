/**
* Class MainConceptosTecView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainConceptosTecView = Backbone.View.extend({

        el: '#conceptostecnico-main',

        /**
        * Constructor Method
        */
        initialize : function() {

            this.$conceptostecnicoSearchTable = this.$('#conceptostecnico-search-table');
            this.$conceptostecnicoSearchTable.DataTable({
                dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('conceptostecnico.index') ),
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'conceptotec_nombre', name: 'conceptotec_nombre' },
                    { data: 'conceptotec_activo', name: 'conceptotec_activo'}
                ],
                buttons: [
                    {
                        text: '<i class="fa fa-plus"></i> Nuevo concepto tecnico',
                        className: 'btn-sm',
                        action: function ( e, dt, node, config ) {
                            window.Misc.redirect( window.Misc.urlFull( Route.route('conceptostecnico.create') ) )
                        }
                    }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('conceptostecnico.show', {conceptostecnico: full.id }) )  +'">' + data + '</a>';
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
