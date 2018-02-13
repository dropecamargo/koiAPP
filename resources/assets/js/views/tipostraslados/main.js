/**
* Class MainTipoTrasladosView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainTipoTrasladosView = Backbone.View.extend({

        el: '#tipostraslados-main',

        /**
        * Constructor Method
        */
        initialize : function() {

            this.$tipostraladosSearchTable = this.$('#tipostraslados-search-table');
            this.$tipostraladosSearchTable.DataTable({
				dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('tipostraslados.index') ),
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'tipotraslado_sigla', name: 'tipotraslado_sigla' },
                    { data: 'tipotraslado_nombre', name: 'tipotraslado_nombre' },
                    { data: 'tipotraslado_activo', name: 'tipotraslado_activo' },
                ],
				buttons: [
					{
						text: '<i class="fa fa-plus"></i> Nuevo tipo de traslado',
                        className: 'btn-sm',
						action: function ( e, dt, node, config ) {
							window.Misc.redirect( window.Misc.urlFull( Route.route('tipostraslados.create') ) )
						}
					}
				],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('tipostraslados.show', {tipostraslados: full.id }) )  +'">' + data + '</a>';
                        }
                    },
                    {
                        targets: [3],
                        width: '15%',
                        render: function ( data, type, full, row ) {
                            return parseInt(data) ? 'Si' : 'No';
                        },

                    },

                ]
			});
        }
    });

})(jQuery, this, this.document);
