/**
* Class MainAnticiposView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainAnticiposView = Backbone.View.extend({

        el: '#anticipos-main',
        events: {
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            var _this = this;

            // Rerefences
            this.$anticiposSearchTable = this.$('#anticipos-search-table');
            
            this.$anticiposSearchTable.DataTable({
                dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull( Route.route('anticipos.index') ),
                    data: function( data ) {
                        data.datatables = true;
                    }
                },
                columns: [ 
                    { data: 'anticipo1_numero', name: 'anticipo1_numero' },
                    { data: 'sucursal_nombre', name: 'sucursal_nombre' },
                    { data: 'tercero_nit', name: 'tercero_nit' },
                    { data: 'tercero_nombre', name: 'anticipo1_tercero' },
                    { data: 'anticipo1_fecha', name: 'anticipo1_fecha' },
                    { data: 'tercero_nombre1', name: 'tercero_nombre1' },
                    { data: 'tercero_nombre2', name: 'tercero_nombre2' },
                    { data: 'tercero_apellido1', name: 'tercero_apellido1' },
                    { data: 'tercero_apellido2', name: 'tercero_apellido2' },
                ],
                buttons: [
                    {
                        text: '<i class="fa fa-plus"></i> Nuevo anticipo',
                        className: 'btn-sm',
                        action: function ( e, dt, node, config ) {
                            window.Misc.redirect( window.Misc.urlFull( Route.route('anticipos.create') ) )
                        }
                    }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '15%',
                        render: function ( data, type, full, row ) {
                           return '<a href="'+ window.Misc.urlFull( Route.route('anticipos.show', {anticipos: full.id }) )  +'">' + data + '</a>';
                        },
                    },
                    {
                        targets: [5,6,7,8],
                        visible: false
                    }
                ]
            });
        }
    });
})(jQuery, this, this.document);
