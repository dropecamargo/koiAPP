/**
* Class MainTiposProductoView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainTiposProductoView = Backbone.View.extend({

        el: '#tiposproducto-main',

        /**
        * Constructor Method
        */
        initialize : function() {

            this.$tiposproductoSearchTable = this.$('#tiposproducto-search-table');
            this.$tiposproductoSearchTable.DataTable({
                dom:"<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('tiposproducto.index') ),
                columns: [
                    { data: 'tipoproducto_codigo', name: 'tipoproducto_codigo' },
                    { data: 'tipoproducto_nombre', name: 'tipoproducto_nombre' },
                    { data: 'tipoproducto_activo', name: 'tipoproducto_activo'}
                ],
				buttons: [
					{
						text: '<i class="fa fa-plus"></i> Nuevo tipo de producto',
                        className: 'btn-sm',
						action: function ( e, dt, node, config ) {
							window.Misc.redirect( window.Misc.urlFull( Route.route('tiposproducto.create') ) )
						}
					}
				],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('tiposproducto.show', {tiposproducto: full.id }) )  +'">' + data + '</a>';
                        }
                    },
                    {
                        targets: 2,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return parseInt(data) ? 'Si' : 'No';
                        }
                    },
                ]
			});
        }
    });

})(jQuery, this, this.document);
