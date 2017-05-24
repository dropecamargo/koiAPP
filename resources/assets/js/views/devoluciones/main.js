/**
* Class MainDevolucionesView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainDevolucionesView = Backbone.View.extend({

        el: '#devoluciones-main',
        events: {
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            var _this = this;

            // Rerefences
            this.$devolucionesSearchTable = this.$('#devoluciones-search-table');
            
            this.$devolucionesSearchTable.DataTable({
                dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('devoluciones.index') ),
                columns: [ 
                    { data: 'devolucion1_numero', name: 'devolucion1_numero' },
                    { data: 'sucursal_nombre', name: 'sucursal_nombre' },
                    { data: 'tercero_nombre', name: 'devolucion1_tercero' },
                    { data: 'devolucion1_factura', name: 'devolucion1_factura' },
                    { data: 'tercero_razonsocial', name: 'tercero_razonsocial'},
                    { data: 'tercero_nombre1', name: 'tercero_nombre1' },
                    { data: 'tercero_nombre2', name: 'tercero_nombre2' },
                    { data: 'tercero_apellido1', name: 'tercero_apellido1' },
                    { data: 'tercero_apellido2', name: 'tercero_apellido2' },
                    { data: 'devolucion1_fh_elaboro', name: 'devolucion1_fh_elaboro' },
                ],
                buttons: [
                    {
                        text: '<i class="fa fa-plus"></i> Nueva devolucion',
                        className: 'btn-sm',
                        action: function ( e, dt, node, config ) {
                            window.Misc.redirect( window.Misc.urlFull( Route.route('devoluciones.create') ) )
                        }
                    }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '15%',
                        render: function ( data, type, full, row ) {
                           return '<a href="'+ window.Misc.urlFull( Route.route('devoluciones.show', {devoluciones: full.id }) )  +'">' + data + '</a>';
                        },
                       
                    },
                    {
                        targets: [4,5,6,7,8],
                        visible: false,
                    },
                ]
            });
        }
    });
})(jQuery, this, this.document);
