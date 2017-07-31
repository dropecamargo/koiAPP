/**
* Class MainTrasladosUbicacionesView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainTrasladosUbicacionesView = Backbone.View.extend({

        el: '#trasladosubicaciones-main',

        /**
        * Constructor Method
        */
        initialize : function() {

            this.$trasladosSearchTable = this.$('#trasladosubicaciones-search-table');

            this.$trasladosSearchTable.DataTable({
				dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('trasladosubicaciones.index') ),
                columns: [
                    {data: 'trasladou1_numero' , name: 'trasladou1_numero' },
                    {data: 'ubicacion_origen' , name: 'ubicacion_origen' },
                    {data: 'ubicacion_destino' , name: 'ubicacion_destino' },
                    {data: 'trasladou1_fecha' , name: 'trasladou1_fecha' },
                ],
				buttons: [
					{
						text: '<i class="fa fa-user-plus"></i> Nuevo traslado de ubicación',
                        className: 'btn-sm',
						action: function ( e, dt, node, config ) {
							window.Misc.redirect( window.Misc.urlFull( Route.route('trasladosubicaciones.create') ) )
						}
					}
				],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('trasladosubicaciones.show', {trasladosubicaciones: full.id }) )  +'">' + data + '</a>';
                        }
                    }
                ]
			});
        }
    });

})(jQuery, this, this.document);
