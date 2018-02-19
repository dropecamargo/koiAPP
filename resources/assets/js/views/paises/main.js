/**
* Class MainPaisesView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainPaisesView = Backbone.View.extend({

        el: '#paises-main',

        /**
        * Constructor Method
        */
        initialize : function() {

            this.$paisesSearchTable = this.$('#paises-search-table');
            this.$paisesSearchTable.DataTable({
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull( Route.route('paises.index') ),
                    data: function( data ) {
                        data.datatables = true;
                    }
                },
                columns: [
                    { data: 'pais_codigo', name: 'pais_codigo' },
                    { data: 'pais_nombre', name: 'pais_nombre'},
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                    }
                ],
                order: [
                	[ 1, 'asc' ],
                ],
			});
        }
    });

})(jQuery, this, this.document);
