/**
* Class MainChequesDevueltosView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainChequesDevueltosView = Backbone.View.extend({

        el: '#chequesdevueltos-main',
        events: {
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            var _this = this;

            // Rerefences
            this.$chequesdevueltosSearchTable = this.$('#chequesdevueltos-search-table');
            
            this.$chequesdevueltosSearchTable.DataTable({
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('chequesdevueltos.index') ),
                columns: [ 
                    { data: 'id', name: 'id' },
                    { data: 'sucursal_nombre', name: 'sucursal_nombre' },
                    { data: 'banco_nombre', name: 'chposfechado1_banco' },
                    { data: 'tercero_nombre', name: 'chposfechado1_tercero' },
                    { data: 'chdevuelto_fecha', name: 'chdevuelto_fecha' },
                    { data: 'tercero_nombre1', name: 'tercero_nombre1' },
                    { data: 'tercero_nombre2', name: 'tercero_nombre2' },
                    { data: 'tercero_apellido1', name: 'tercero_apellido1' },
                    { data: 'tercero_apellido2', name: 'tercero_apellido2' },
                ],
                columnDefs: [
                    {
                        targets: 0,
                        searchable: false,
                        width: '15%',
                        render: function ( data, type, full, row ) {
                           return '<a href="'+ window.Misc.urlFull( Route.route('chequesdevueltos.show', {chequesdevueltos: full.id }) )  +'">' + data + '</a>';
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
