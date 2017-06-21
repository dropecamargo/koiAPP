/**
* Class MainOrdenesView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainOrdenesView = Backbone.View.extend({

        el: '#orden-main',
        events: {
            'click .btn-search': 'search',
            'click .btn-clear': 'clear'
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            var _this = this;

            // References
            this.$ordenesSearchTable = this.$('#orden-search-table');
            this.$searchordenOrden = this.$('#searchorden_orden_id');
            this.$searchordenTercero = this.$('#searchorden_tercero');
            this.$searchordenTerceroName = this.$('#searchorden_tercero_nombre');
            this.$searchordenEstado = this.$('#searchorden_orden_estado');

            this.ordenesSearchTable = this.$ordenesSearchTable.DataTable({
                dom: "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull( Route.route('ordenes.index') ),
                    data: function( data ) {
                        data.persistent = true;
                        data.id = _this.$searchordenOrden.val();
                        data.tercero_nit = _this.$searchordenTercero.val();
                        data.tercero_nombre = _this.$searchordenTerceroName.val();
                        data.orden_abierta = _this.$searchordenEstado.val();
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'orden_fh_elaboro', name: 'orden_fh_elaboro' },
                    { data: 'tercero_nombre', name: 'tercero_nombre' },
                    { data: 'orden_abierta', name: 'orden_abierta' },


                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        searchable: false,
                        render: function ( data, type, full, row ) {
                            
                            return '<a href="'+ window.Misc.urlFull( Route.route('ordenes.show', {ordenes: full.id }) )  +'">' + data + '</a>';
                        }
                    },
                    {
                        targets: 3,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return data ? 'Si' : 'No';
                        },
                    }
                ],
               
            });
        },

        search: function(e) {
            e.preventDefault();

            this.ordenesSearchTable.ajax.reload();
        },

        clear: function(e) {
            e.preventDefault();

            this.$searchordenOrden.val('');
            this.$searchordenTercero.val('');
            this.$searchordenTerceroName.val('');
            this.$searchordenEstado.val('');

            this.ordenesSearchTable.ajax.reload();
        },
    });

})(jQuery, this, this.document);
