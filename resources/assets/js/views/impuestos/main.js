/**
* Class MainImpuestosView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainImpuestosView = Backbone.View.extend({

        el: '#impuestos-main',

        /**
        * Constructor Method
        */
        initialize : function() {

            this.$impuestosSearchTable = this.$('#impuestos-search-table');

            this.$impuestosSearchTable.DataTable({
                dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('impuestos.index') ),
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'impuesto_nombre', name: 'impuesto_nombre' },
                    { data: 'impuesto_activo', name: 'impuesto_activo'}
                ],
                buttons: [
                    {
                        text: '<i class="fa fa-plus"></i> Nueva impuesto',
                        className: 'btn-sm',
                        action: function ( e, dt, node, config ) {
                            window.Misc.redirect( window.Misc.urlFull( Route.route('impuestos.create') ) )
                        }
                    }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('impuestos.show', {impuestos: full.id }) )  +'">' + data + '</a>';
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
