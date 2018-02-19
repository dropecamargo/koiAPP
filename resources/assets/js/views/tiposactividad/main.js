/**
* Class MainTipoActividadView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainTipoActividadView = Backbone.View.extend({

        el: '#tiposactividad-main',

        /**
        * Constructor Method
        */
        initialize : function() {

            this.$tiposactividadSearchTable = this.$('#tiposactividad-search-table');
            this.$tiposactividadSearchTable.DataTable({
				dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('tiposactividad.index') ),
                columns: [
                    { data: 'tipoactividad_nombre', name: 'tipoactividad_nombre' },
                    { data: 'tipoactividad_activo', name: 'tipoactividad_activo' },
                    { data: 'tipoactividad_comercial', name: 'tipoactividad_comercial' },
                    { data: 'tipoactividad_tecnico', name: 'tipoactividad_tecnico' },
                    { data: 'tipoactividad_cartera', name: 'tipoactividad_cartera' },
                ],
				buttons: [
					{
						text: '<i class="fa fa-plus"></i> Nuevo tipo de actividad',
                        className: 'btn-sm',
						action: function ( e, dt, node, config ) {
							window.Misc.redirect( window.Misc.urlFull( Route.route('tiposactividad.create') ) )
						}
					}
				],
                columnDefs: [
                    {
                        targets: 0,
                        width: '40%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('tiposactividad.show', {tiposactividad: full.id }) )  +'">' + data + '</a>';
                        }
                    },
                    {
                        targets: [1,2,3,4],
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
