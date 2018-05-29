/**
* Class MainCajasMenoresView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainCajasMenoresView = Backbone.View.extend({

        el: '#cajasmenores-main',

        /**
        * Constructor Method
        */
        initialize : function() {
            this.$cajaMenorSearchTable = this.$('#cajasmenores-search-table');

            this.$cajaMenorSearchTable.DataTable({
                dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('cajasmenores.index') ),
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'cajamenor1_tercero', name: 'cajamenor1_tercero' },
                    { data: 'cajamenor1_observaciones', name: 'cajamenor1_observaciones'}
                ],
                buttons: [
                    {
                        text: '<i class="fa fa-plus"></i> Nuevo',
                        className: 'btn-sm',
                        action: function ( e, dt, node, config ) {
                            window.Misc.redirect( window.Misc.urlFull( Route.route('cajasmenores.create') ) )
                        }
                    }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('cajasmenores.show', {cajasmenores: full.id }) )  +'">' + data + '</a>';
                        }
                    }
                ]
            });
        }
    });

})(jQuery, this, this.document);
