/**
* Class MainLineasView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainLineasView = Backbone.View.extend({

        el: '#lineas-main',

        /**
        * Constructor Method
        */
        initialize : function() {

            this.$lineasSearchTable = this.$('#lineas-search-table');
            this.$lineasSearchTable.DataTable({
				dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull( Route.route('lineas.index') ),
                    data: function(data){
                        data.datatables = true;
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'linea_nombre', name: 'linea_nombre' },
                    { data: 'linea_activo', name: 'linea_activo' }
                ],
				buttons: [
					{
						text: '<i class="fa fa-plus"></i> Nueva linea',
                        className: 'btn-sm',
						action: function ( e, dt, node, config ) {
							window.Misc.redirect( window.Misc.urlFull( Route.route('lineas.create') ) )
						}
					}
				],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('lineas.show', {lineas: full.id }) )  +'">' + data + '</a>';
                        }
                    },
                    {
                        targets: 2,
                        width: '30%',
                        render: function ( data, type, full, row ) {
                            return parseInt(data) ? 'Si' : 'No';
                        },
                    }
                ]
			});
        }
    });

})(jQuery, this, this.document);
