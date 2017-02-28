/**
* Class MainMarcasView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainMarcasView = Backbone.View.extend({

        el: '#marcas-main',

        /**
        * Constructor Method
        */
        initialize : function() {

            this.$marcasSearchTable = this.$('#marcas-search-table');

            this.$marcasSearchTable.DataTable({
                dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('marcas.index') ),
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'marca_nombre', name: 'marca_nombre' },
                    { data: 'marca_activo', name: 'marca_activo'}
                ],
                buttons: [
                    {
                        text: '<i class="fa fa-plus"></i> Nueva marca',
                        className: 'btn-sm',
                        action: function ( e, dt, node, config ) {
                            window.Misc.redirect( window.Misc.urlFull( Route.route('marcas.create') ) )
                        }
                    }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('marcas.show', {marcas: full.id }) )  +'">' + data + '</a>';
                        }
                    },
                    {
                        targets: 2,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return data ? 'Si' : 'No';
                        },
                    }
                ]
            });
        }
    });

})(jQuery, this, this.document);
