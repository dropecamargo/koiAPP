/**
* Class MainAutorizacionesCaView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainAutorizacionesCaView = Backbone.View.extend({

        el: '#autorizacionesca-main',

        /**
        * Constructor Method
        */
        initialize : function() {

            // Rerefences
            this.$ajustesSearchTable = this.$('#autorizacionesca-search-table');
            this.$ajustesSearchTable.DataTable({
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('autorizacionesca.index') ),
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'autorizaca_tercero', name: 'autorizaca_tercero' },
                    { data: 'autorizaca_vencimiento', name: 'autorizaca_vencimiento' },
                    { data: 'autorizaca_plazo', name: 'autorizaca_plazo' },
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '25%',
                        render: function ( data, type, full, row ) {
                           return '<a href="'+ window.Misc.urlFull( Route.route('autorizacionesca.show', {autorizacionesca: full.id }) )  +'">' + data + '</a>';
                        },

                    },
                ]
            });
        }
    });
})(jQuery, this, this.document);
