/**
* Class MainCuentaBancosView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainCuentaBancosView = Backbone.View.extend({

        el: '#cuentabancos-main',

        /**
        * Constructor Method
        */
        initialize : function() {

            this.$cuentabancosSearchTable = this.$('#cuentabancos-search-table');

            this.$cuentabancosSearchTable.DataTable({
                dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('cuentabancos.index') ),
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'cuentabanco_nombre', name: 'cuentabanco_nombre' },
                    { data: 'banco_nombre', name: 'banco_nombre' },
                    { data: 'cuentabanco_activa', name: 'cuentabanco_activa'}
                ],
                buttons: [
                    {
                        text: '<i class="fa fa-plus"></i> Nueva cuenta de banco',
                        className: 'btn-sm',
                        action: function ( e, dt, node, config ) {
                            window.Misc.redirect( window.Misc.urlFull( Route.route('cuentabancos.create') ) )
                        }
                    }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('cuentabancos.show', {cuentabancos: full.id }) )  +'">' + data + '</a>';
                        }
                    },
                    {
                        targets: 3,
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
