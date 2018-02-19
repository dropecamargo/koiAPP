/**
* Class MainGestionCobrosView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainGestionCobrosView = Backbone.View.extend({

        el: '#gestioncobros-main',

        /**
        * Constructor Method
        */
        initialize : function() {

            this.$gestioncobrosSearchTable = this.$('#gestioncobros-search-table');
            this.$gestioncobrosSearchTable.DataTable({
                dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('gestioncobros.index') ),
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'conceptocob_nombre', name: 'gestioncobro_conceptocob' },
                    { data: 'tercero_nombre', name: 'gestioncobro_tercero' },
                    { data: 'gestioncobro_fh', name: 'gestioncobro_fh'},
                    { data: 'gestioncobro_proxima', name: 'gestioncobro_proxima'},
                    { data: 'tercero_nit', name: 'tercero_nit'},
                    { data: 'tercero_nombre1', name: 'tercero_nombre1'},
                    { data: 'tercero_nombre2', name: 'tercero_nombre2'},
                    { data: 'tercero_apellido1', name: 'tercero_apellido1'},
                    { data: 'tercero_apellido2', name: 'tercero_apellido2'},
                ],
                buttons: [
                    {
                        text: '<i class="fa fa-plus"></i> Nueva gestion de cobro',
                        className: 'btn-sm',
                        action: function ( e, dt, node, config ) {
                            window.Misc.redirect( window.Misc.urlFull( Route.route('gestioncobros.create') ) )
                        }
                    }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        searchable:false,
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('gestioncobros.show', {gestioncobros: full.id }) )  +'">' + data + '</a>';
                        }
                    },
                    {
                        targets: [5,6,7,8,9],
                        visible: false
                    }
                ]
            });
        }
    });

})(jQuery, this, this.document);
