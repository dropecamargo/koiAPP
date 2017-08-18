/**
* Class MainEgresoView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainEgresoView = Backbone.View.extend({

        el: '#egresos-main',

        /**
        * Constructor Method
        */
        initialize : function() {

            this.$egresos1SearchTable = this.$('#egresos-search-table');

            this.$egresos1SearchTable.DataTable({
                dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('egresos.index') ),
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'tercero_nombre', name: 'tercero_nombre' },
                    { data: 'regional_nombre', name: 'regional_nombre'},
                    { data: 'egreso1_observaciones', name: 'egreso1_observaciones'},
                ],
                buttons: [
                    {
                        text: '<i class="fa fa-plus"></i> Nuevo egreso',
                        className: 'btn-sm',
                        action: function ( e, dt, node, config ) {
                            window.Misc.redirect( window.Misc.urlFull( Route.route('egresos.create') ) )
                        }
                    }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('egresos.show', {egresos: full.id }) )  +'">' + data + '</a>';
                        }
                    }
                ]
            });
        }
    });

})(jQuery, this, this.document);