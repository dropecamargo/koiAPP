/**
* Class MainAsientosView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainAsientosView = Backbone.View.extend({

        el: '#asientos-main',
        events: {
            'click .btn-search': 'search',
            'click .btn-clear': 'clear'
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            var _this = this;
            this.$asientosSearchTable = this.$('#asientos-search-table');

            // References
            this.$searchTercero = this.$('#search_tercero');
            this.$searchTerceroName = this.$('#search_tercero_nombre');
            this.$searchReferencia = this.$('#search_referencia');
            this.$searchDocumento = this.$('#search_documento');

            this.asientosSearchTable = this.$asientosSearchTable.DataTable({
                dom: "<'row'<'col-sm-4'B>>" +
                    "<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull( Route.route('asientos.index') ),
                    data: function( data ) {
                        data.persistent = true;
                        data.asiento_tercero_nit = _this.$searchTercero.val();
                        data.asiento_tercero_nombre = _this.$searchTerceroName.val();
                        data.asiento_documento = _this.$searchDocumento.val();
                    }
                },
                columns: [
                    { data: 'asiento1_numero', name: 'asiento1_numero' },
                    { data: 'documento_nombre', name: 'documento_nombre' },
                    { data: 'asiento1_ano', name: 'asiento1_ano' },
                    { data: 'asiento1_mes', name: 'asiento1_mes' },
                    { data: 'tercero_nit', name: 'tercero_nit' },
                    { data: 'tercero_nombre', name: 'tercero_nombre' },
                    { data: 'tercero_razonsocial', name: 'tercero_razonsocial'},
                    { data: 'tercero_nombre1', name: 'tercero_nombre1' },
                    { data: 'tercero_nombre2', name: 'tercero_nombre2' },
                    { data: 'tercero_apellido1', name: 'tercero_apellido1' },
                    { data: 'tercero_apellido2', name: 'tercero_apellido2' },
                    { data: 'asiento1_preguardado', name: 'asiento1_preguardado' }
                ],
                buttons: [
                   {
                       text: 'Importar',
                       className: 'btn-sm',
                       action: function () {
                           // AsientoActionView undelegateEvents
                           if ( _this.importActionView instanceof Backbone.View ){
                               _this.importActionView.stopListening();
                               _this.importActionView.undelegateEvents();
                           }

                            _this.importActionView = new app.ImportProductoActionView({
                               parameters: {
                                   title: 'asientos',
                                   url: window.Misc.urlFull( Route.route('asientos.import') )
                               }
                           });

                           _this.importActionView.render();
                       }
                   }
               ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '7%',
                        render: function ( data, type, full, row ) {
                            if( parseInt(full.asiento1_preguardado) ) {
                                return '<a href="'+ window.Misc.urlFull( Route.route('asientos.edit', {asientos: full.id }) )  +'">' + data + ' <span class="label label-warning">PRE</span></a>';
                            }else{
                                return '<a href="'+ window.Misc.urlFull( Route.route('asientos.show', {asientos: full.id }) )  +'">' + data + '</a>';
                            }
                        }
                    },
                    {
                        targets: [2, 3],
                        width: '7%'
                    },
                    {
                        targets: 4,
                        width: '15%'
                    },
                    {
                        targets: 5,
                        searchable: false
                    },
                    {
                        targets: [6, 7, 8, 9, 10],
                        visible: false
                    },
                    {
                        targets: 11,
                        visible: false,
                        searchable: false
                    }
                ],
                order: [
                	[ 2, 'desc' ], [ 3, 'desc' ]
                ],
			});
        },

        search: function(e) {
            e.preventDefault();

            this.asientosSearchTable.ajax.reload();
        },

        clear: function(e) {
            e.preventDefault();

            // References
            this.$searchTercero.val('');
            this.$searchTerceroName.val('');
            this.$searchReferencia.val('');
            this.$searchDocumento.val('').trigger('change');

            this.asientosSearchTable.ajax.reload();
        },
    });

})(jQuery, this, this.document);
