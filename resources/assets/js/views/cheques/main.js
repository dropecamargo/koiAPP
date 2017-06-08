/**
* Class MainChequesView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainChequesView = Backbone.View.extend({

        el: '#cheques-main',
        events: {
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            var _this = this;

            // Rerefences
            this.$chequesSearchTable = this.$('#cheques-search-table');
            
            this.$chequesSearchTable.DataTable({
                dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('cheques.index') ),
                columns: [ 
                    { data: 'chposfechado1_numero', name: 'chposfechado1_numero' },
                    { data: 'sucursal_nombre', name: 'sucursal_nombre' },
                    { data: 'chposfechado1_banco', name: 'chposfechado1_banco' },
                    { data: 'tercero_nombre', name: 'chposfechado1_tercero' },
                    { data: 'chposfechado1_fecha', name: 'chposfechado1_fecha' },
                    { data: 'tercero_nombre1', name: 'tercero_nombre1' },
                    { data: 'tercero_nombre2', name: 'tercero_nombre2' },
                    { data: 'tercero_apellido1', name: 'tercero_apellido1' },
                    { data: 'tercero_apellido2', name: 'tercero_apellido2' },
                ],
                buttons: [
                    {
                        text: '<i class="fa fa-plus"></i> Nuevo cheque posfechado',
                        className: 'btn-sm',
                        action: function ( e, dt, node, config ) {
                            window.Misc.redirect( window.Misc.urlFull( Route.route('cheques.create') ) )
                        }
                    }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '15%',
                        render: function ( data, type, full, row ) {
                           return '<a href="'+ window.Misc.urlFull( Route.route('cheques.show', {cheques: full.id }) )  +'">' + data + '</a>';
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
