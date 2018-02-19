/**
* Class MainDepartamentoView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainDepartamentoView = Backbone.View.extend({
        
        el: '#departamentos-main',

        /**
        * Constructor Method
        */
        initialize : function() {

            this.$departamentosSearchTable = this.$('#departamentos-search-table');
            this.$departamentosSearchTable.DataTable({
                dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'><'col-sm-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('departamentos.index') ),
                columns: [
                    { data: 'departamento_codigo', name: 'departamento_codigo' },
                    { data: 'departamento_nombre', name: 'departamento_nombre'}
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('departamentos.show', {departamentos: full.id }) )  +'">' + data + '</a>';
                        }
                    }
                ]
			});
        }
    });
})(jQuery, this, this.document);
