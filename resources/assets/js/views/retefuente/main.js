/**
* Class MainReteFuenteView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainReteFuenteView = Backbone.View.extend({

        el: '#retefuentes-main',

        /**
        * Constructor Method
        */
        initialize : function() {

            this.$retefuentesSearchTable = this.$('#retefuentes-search-table');

            this.$retefuentesSearchTable.DataTable({
                dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('retefuentes.index') ),
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'retefuente_nombre', name: 'retefuente_nombre' },
                    { data: 'retefuente_activo', name: 'retefuente_activo'}
                ],
                buttons: [
                    {
                        text: '<i class="fa fa-plus"></i> Nueva retefuente',
                        className: 'btn-sm',
                        action: function ( e, dt, node, config ) {
                            window.Misc.redirect( window.Misc.urlFull( Route.route('retefuentes.create') ) )
                        }
                    }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('retefuentes.show', {retefuentes: full.id }) )  +'">' + data + '</a>';
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
