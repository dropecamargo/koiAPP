/**
* Class MainActivosFijosView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainActivosFijosView = Backbone.View.extend({

        el: '#activofijos-main',

        /**
        * Constructor Method
        */
        initialize : function() {
            this.$activofijosSearchTable = this.$('#activofijos-search-table');

            this.$activofijosSearchTable.DataTable({
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull( Route.route('activosfijos.index') ),
                    data: function( data ) {
                        data.datatables = true;
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'activofijo_placa', name: 'activo_placa' },
                    { data: 'activofijo_serie', name: 'activo_serie' },
                    { data: 'tercero_nombre', name: 'tercero_nombre'},
                    { data: 'tipoactivo_nombre', name: 'tipoactivo_nombre'},
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('activosfijos.show', {activosfijos: full.id }) )  +'">' + data + '</a>';
                        }
                    }
                ]
            });
        }
    });

})(jQuery, this, this.document);
