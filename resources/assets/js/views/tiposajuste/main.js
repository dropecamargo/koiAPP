/**
* Class MainTipoAjusteView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainTipoAjusteView = Backbone.View.extend({

        el: '#tiposajuste-main',

        /**
        * Constructor Method
        */
        initialize : function() {

            this.$tiposajusteSearchTable = this.$('#tiposajuste-search-table');
            this.$tiposajusteSearchTable.DataTable({
				dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('tiposajuste.index') ),
                columns: [
                    { data: 'tipoajuste_sigla', name: 'tipoajuste_sigla' },
                    { data: 'tipoajuste_nombre', name: 'tipoajuste_nombre' },
                    { data: 'tipoajuste_tipo', name: 'tipoajuste_tipo' },
                    { data: 'tipoajuste_activo', name: 'tipoajuste_activo' },
                ],
				buttons: [
					{
						text: '<i class="fa fa-plus"></i> Nuevo tipo ajuste',
                        className: 'btn-sm',
						action: function ( e, dt, node, config ) {
							window.Misc.redirect( window.Misc.urlFull( Route.route('tiposajuste.create') ) )
						}
					}
				],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('tiposajuste.show', {tiposajuste: full.id }) )  +'">' + data + '</a>';
                        }
                    },
                    {
                        targets: [3],
                        width: '15%',
                        render: function ( data, type, full, row ) {
                            return parseInt(data) ? 'Si' : 'No';
                        },

                    }
                ]
			});
        }
    });

})(jQuery, this, this.document);
