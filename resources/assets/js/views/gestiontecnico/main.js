/**
* Class MainGestionesTecnicoView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainGestionesTecnicoView = Backbone.View.extend({

        el: '#gestionestecnico-main',

        /**
        * Constructor Method
        */
        initialize : function() {

            this.$gestionestecnicoSearchTable = this.$('#gestionestecnico-search-table');

            this.$gestionestecnicoSearchTable.DataTable({
                dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('gestionestecnico.index') ),
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'conceptotec_nombre', name: 'gestiontecnico_conceptotec' },
                    { data: 'tercero_nombre', name: 'gestiontecnico_tercero' },
                    { data: 'gestiontecnico_fh', name: 'gestiontecnico_fh'},
                    { data: 'tercero_nit', name: 'tercero_nit'},
                    { data: 'tercero_nombre1', name: 'tercero_nombre1'},
                    { data: 'tercero_nombre2', name: 'tercero_nombre2'},
                    { data: 'tercero_apellido1', name: 'tercero_apellido1'},
                    { data: 'tercero_apellido2', name: 'tercero_apellido2'},
                ],
                buttons: [
                    {
                        text: '<i class="fa fa-plus"></i> Nueva gestión tecnica',
                        className: 'btn-sm',
                        action: function ( e, dt, node, config ) {
                            window.Misc.redirect( window.Misc.urlFull( Route.route('gestionestecnico.create') ) )
                        }
                    }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        searchable:false,
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('gestionestecnico.show', {gestionestecnico: full.id }) )  +'">' + data + '</a>';
                        }
                    },
                    {
                        targets: [4,5,6,7,8],
                        visible: false
                    }
                ]
            });
        }
    });

})(jQuery, this, this.document);