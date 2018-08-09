/**
* Class MainGestionDeudoresView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainGestionDeudoresView = Backbone.View.extend({

        el: '#gestiondeudores-main',

        /**
        * Constructor Method
        */
        initialize : function() {
            this.$gestiondeudoresSearchTable = this.$('#gestiondeudores-search-table');
            this.$gestiondeudoresSearchTable.DataTable({
                dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('gestiondeudores.index') ),
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'deudor_nombre', name: 'deudor_nombre' },
                    { data: 'tercero_nombre', name: 'tercero_nombre' },
                    { data: 'gestiondeudor_fh', name: 'gestiondeudor_fh'},
                    { data: 'gestiondeudor_proxima', name: 'gestiondeudor_proxima'},
                    { data: 'deudor_nombre1', name: 'deudor.deudor_nombre1'},
                    { data: 'deudor_nombre2', name: 'deudor.deudor_nombre2'},
                    { data: 'deudor_apellido1', name: 'deudor.deudor_apellido1'},
                    { data: 'deudor_apellido2', name: 'deudor.deudor_apellido2'},
                ],
                buttons: [
                    {
                        text: '<i class="fa fa-plus"></i> Nueva gestión de deudor',
                        className: 'btn-sm',
                        action: function ( e, dt, node, config ) {
                            window.Misc.redirect( window.Misc.urlFull( Route.route('gestiondeudores.create') ) )
                        }
                    }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        searchable:false,
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('gestiondeudores.show', {gestiondeudores: full.id }) )  +'">' + data + '</a>';
                        }
                    },
                    {
                        targets: [5,6,7,8],
                        visible: false,
                        searchable: true,
                    },
                    {
                        targets: [1,2],
                        searchable: false,
                    }
                ]
            });
        }
    });

})(jQuery, this, this.document);
