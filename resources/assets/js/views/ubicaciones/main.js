/**
* Class MainUbicacionesView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainUbicacionesView = Backbone.View.extend({

        el: '#ubicaciones-main',

        /**
        * Constructor Method
        */
        initialize : function() {

            this.$ubicacionesSearchTable = this.$('#ubicaciones-search-table');

            this.$ubicacionesSearchTable.DataTable({
                dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull( Route.route('ubicaciones.index') ),
                    data: function( data ) {
                        data.datatables = true;
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'ubicacion_nombre', name: 'ubicacion_nombre' },
                    { data: 'sucursal_nombre', name: 'sucursal_nombre'},
                    { data: 'ubicacion_activo', name: 'ubicacion_activo'}
                ],
                buttons: [
                    {
                        text: '<i class="fa fa-plus"></i> Nuevo ubicación',
                        className: 'btn-sm',
                        action: function ( e, dt, node, config ) {
                            window.Misc.redirect( window.Misc.urlFull( Route.route('ubicaciones.create') ) )
                        }
                    }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        searchable:false,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('ubicaciones.show', {ubicaciones: full.id }) )  +'">' + data + '</a>';
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
