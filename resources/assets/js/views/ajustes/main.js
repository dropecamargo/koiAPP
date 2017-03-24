/**
* Class MainAjustesView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainAjustesView = Backbone.View.extend({

        el: '#ajustes-main',
        events: {
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            var _this = this;

            // Rerefences
            this.$productosSearchTable = this.$('#ajustes-search-table');
            
            this.$productosSearchTable.DataTable({
                dom:"<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('ajustes.index') ),
                columns: [ 
                    { data: 'ajuste1_numero', name: 'ajuste1_numero' },
                    { data: 'tipoajuste_nombre', name: 'tipoajuste_nombre' },
                    { data: 'sucursal_nombre', name: 'sucursal_nombre' },
                    { data: 'ajuste1_fecha', name: 'ajuste1_fecha' },
                ],
                buttons: [
                    {
                        text: '<i class="fa fa-cog"></i> Nuevo Ajuste',
                        className: 'btn-sm',
                        action: function ( e, dt, node, config ) {
                            window.Misc.redirect( window.Misc.urlFull( Route.route('ajustes.create') ) )
                        }
                    }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '25%',
                        render: function ( data, type, full, row ) {
                           return '<a href="'+ window.Misc.urlFull( Route.route('ajustes.show', {ajustes: full.id }) )  +'">' + data + '</a>';
                        },
                       
                    }, 
                ]
            });
        }
    });
})(jQuery, this, this.document);
