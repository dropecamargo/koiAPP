/**
* Class MainMedioPagosView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainMedioPagosView = Backbone.View.extend({

        el: '#mediopagos-main',

        /**
        * Constructor Method
        */
        initialize : function() {

            this.$mediopagosSearchTable = this.$('#mediopagos-search-table');
            this.$mediopagosSearchTable.DataTable({
                dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('mediopagos.index') ),
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'mediopago_nombre', name: 'mediopago_nombre' },
                    { data: 'mediopago_activo', name: 'mediopago_activo'}
                ],
                buttons: [
                    {
                        text: '<i class="fa fa-plus"></i> Nuevo medio de pago',
                        className: 'btn-sm',
                        action: function ( e, dt, node, config ) {
                            window.Misc.redirect( window.Misc.urlFull( Route.route('mediopagos.create') ) )
                        }
                    }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('mediopagos.show', {mediopagos: full.id }) )  +'">' + data + '</a>';
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
