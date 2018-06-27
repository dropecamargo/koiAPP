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
        events: {
            'click .btn-search': 'search',
            'click .btn-clear': 'clear'
        },
        /**
        * Constructor Method
        */
        initialize : function() {
            var _this = this;

            // Rerefences
            this.$searchCajaMenorTercero = this.$('#searchcajamenor_tercero');
            this.$searchCajaMenorRegional = this.$('#searchcajamenor_regional');
            this.$searchCajaMenorNumero = this.$('#searchcajamenor_numero');
            this.$cajaMenorSearchTable = this.$('#cajasmenores-search-table');

            this.cajaMenorSearchTable = this.$cajaMenorSearchTable.DataTable({
                dom:"<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull( Route.route('cajasmenores.index') ),
                    data: function( data ) {
                        data.persistent = true;
                        data.nit = _this.$searchCajaMenorTercero.val();
                        data.regional = _this.$searchCajaMenorRegional.val();
                        data.numero = _this.$searchCajaMenorNumero.val();
                    }
                },
                columns: [
                    { data: 'cajamenor1_numero', name: 'cajamenor1_numero' },
                    { data: 'regional_nombre', name: 'regional_nombre' },
                    { data: 'tercero_nombre', name: 'tercero_nombre' },
                    { data: 'cuentabanco_nombre', name: 'cuentabanco_nombre'}
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            if( parseInt(full.cajamenor1_preguardado) ) {
                                return '<a href="'+ window.Misc.urlFull( Route.route('cajasmenores.edit', {cajasmenores: full.id }) )  +'">' + data + ' <span class="label label-warning pull-right">PRE</span></a>';
                            }else{
                                return '<a href="'+ window.Misc.urlFull( Route.route('cajasmenores.show', {cajasmenores: full.id }) )  +'">' + data + '</a>';
                            }
                        }
                    }
                ]
            });
        },

        search: function(e) {
            e.preventDefault();

            this.cajaMenorSearchTable.ajax.reload();
        },

        clear: function(e) {
            e.preventDefault();

            this.$searchCajaMenorRegional.val('').trigger('change');
            this.$searchCajaMenorTercero.val('');
            this.$searchCajaMenorNumero.val('');
            this.cajaMenorSearchTable.ajax.reload();
        },
    });

})(jQuery, this, this.document);
