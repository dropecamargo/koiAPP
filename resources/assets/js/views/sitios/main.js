/**
* Class MainSitiosView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainSitiosView = Backbone.View.extend({

        el: '#sitios-main',

        /**
        * Constructor Method
        */
        initialize : function() {

            this.$sitiosSearchTable = this.$('#sitios-search-table');

            this.$sitiosSearchTable.DataTable({
                dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('sitios.index') ),
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'sitio_nombre', name: 'sitio_nombre' },
                    { data: 'sitio_activo', name: 'sitio_activo'}
                ],
                buttons: [
                    {
                        text: '<i class="fa fa-plus"></i> Nuevo sitio',
                        className: 'btn-sm',
                        action: function ( e, dt, node, config ) {
                            window.Misc.redirect( window.Misc.urlFull( Route.route('sitios.create') ) )
                        }
                    }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('sitios.show', {sitios: full.id }) )  +'">' + data + '</a>';
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
