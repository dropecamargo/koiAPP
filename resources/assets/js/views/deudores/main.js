/**
* Class MainDeudoresView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainDeudoresView = Backbone.View.extend({

        el: '#deudores-main',

        /**
        * Constructor Method
        */
        initialize : function() {

            this.$deudoresSearchTable = this.$('#deudores-search-table');

            this.$deudoresSearchTable.DataTable({
                dom: "<'row'<'col-sm-8'l><'col-sm-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('deudores.index') ),
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'tercero_nombre', name: 'tercero_nombre' },
                    { data: 'deudor_nit', name: 'deudor_nit' },
                    { data: 'deudor_nombre', name: 'deudor_nombre' },
                    { data: 'deudor_razonsocial', name: 'deudor_razonsocial' },
                    { data: 'deudor_nombre1', name: 'deudor_nombre1' },
                    { data: 'deudor_nombre2', name: 'deudor_nombre2' },
                    { data: 'deudor_apellido1', name: 'deudor_apellido1' },
                    { data: 'deudor_apellido2', name: 'deudor_apellido2' }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('deudores.show', {deudores: full.id }) )  +'">' + data + '</a>';
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
