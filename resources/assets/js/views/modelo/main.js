/**
* Class MainModelosView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainModelosView = Backbone.View.extend({

        el: '#modelos-main',

        /**
        * Constructor Method
        */
        initialize : function() {

            this.$modelosSearchTable = this.$('#modelos-search-table');
            
            this.$modelosSearchTable.DataTable({
				
                dom:"<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('modelos.index') ),
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'modelo_nombre', name: 'modelo_nombre' },
                    { data: 'modelo_activo', name: 'modelo_activo'}
                ],
				buttons: [
					{
						text: '<i class="fa fa-plus"></i> Nuevo Modelo',
                        className: 'btn-sm',
						action: function ( e, dt, node, config ) {
							window.Misc.redirect( window.Misc.urlFull( Route.route('modelos.create') ) )
						}
					}
				],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('modelos.show', {modelos: full.id }) )  +'">' + data + '</a>';
                        }
                    },
                     {
                        targets: [2],
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
