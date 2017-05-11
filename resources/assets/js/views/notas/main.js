/**
* Class MainNotaView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainNotaView = Backbone.View.extend({

        el: '#notas-main',
        events: {
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            var _this = this;

            // Rerefences
            this.$notasSearchTable = this.$('#notas-search-table');
            
            this.$notasSearchTable.DataTable({
                dom:"<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('notas.index') ),
                columns: [ 
                    { data: 'id', name: 'id' },
                    { data: 'sucursal_nombre', name: 'sucursal_nombre' },
                    { data: 'tercero_nombre', name: 'tercero_nombre' },
                    { data: 'nota1_observaciones', name: 'nota1_observaciones' }
                ],
                buttons: [
                    {
                        text: '<i class="fa fa-user-plus"></i> Nueva Nota',
                        className: 'btn-sm',
                        action: function ( e, dt, node, config ) {
                            window.Misc.redirect( window.Misc.urlFull( Route.route('notas.create') ) )
                        }
                    }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('notas.show', {notas: full.id }) )  +'">' + data + '</a>';
                        }
                    }
                ]
            });
        },

    });
})(jQuery, this, this.document);
