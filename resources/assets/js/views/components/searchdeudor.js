/**
* Class ComponentSearchDeudorView  of Backbone
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ComponentSearchDeudorView = Backbone.View.extend({

      	el: 'body',
        template: _.template( ($('#koi-search-deudor-component-tpl').html() || '') ),

		events: {
            'click .btn-koi-search-deudor-component-table': 'searchTercero',
            'click .btn-search-koi-search-deudor-component': 'search',
            'click .btn-clear-koi-search-deudor-component': 'clear',
            'click .a-koi-search-deudor-component-table': 'setTercero'
		},

        /**
        * Constructor Method
        */
		initialize: function() {
			// Initialize
            this.$modalComponent = this.$('#modal-search-component');
		},

		searchTercero: function(e) {
            e.preventDefault();
            var _this = this;

            // Render template
            this.$modalComponent.find('.content-modal').html( this.template({ }) );

            // References
            this.$searchNit = this.$('#koi_search_deudor_nit');
            this.$searchName = this.$('#koi_search_deudor_nombre');

            this.$deudoresSearchTable = this.$modalComponent.find('#koi-search-deudor-component-table');

            this.$inputContent = this.$("#"+$(e.currentTarget).attr("data-field"));
            this.$wraperConten = this.$("#"+this.$inputContent.attr("data-wrapper"));
            this.$inputName = this.$("#"+this.$inputContent.attr("data-name"));
            this.tercero = this.$inputContent.attr("data-tercero");

            if ( _.isUndefined(this.tercero) ) {
                alertify.error('Por favor ingrese un tercero.');
                return;
            }

            this.deudoresSearchTable = this.$deudoresSearchTable.DataTable({
                dom: "<'row'<'col-sm-12'tr>>" +
               		"<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull( Route.route('deudores.index') ),
                    data: function( data ) {
                        data.deudor_tercero = _this.tercero;
                        data.deudor_nit = _this.$searchNit.val();
                        data.deudor_nombre = _this.$searchName.val();
                    }
                },

                columns: [
                    { data: 'deudor_nit', name: 'deudor_nit' },
                    { data: 'deudor_nombre', name: 'deudor_nombre' },
                    { data: 'deudor_razonsocial', name: 'deudor_razonsocial'},
                    { data: 'deudor_nombre1', name: 'deudor_nombre1' },
                    { data: 'deudor_nombre2', name: 'deudor_nombre2' },
                    { data: 'deudor_apellido1', name: 'deudor_apellido1' },
                    { data: 'deudor_apellido2', name: 'deudor_apellido2' },
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '15%',
                        searchable: false,
                        render: function ( data, type, full, row ) {

                            // Render show deudor in dashboard
                            if (_this.$fieldRender == "show")
                                return '<a href='+ window.Misc.urlFull( Route.route('deudores.show', { deudores: full.id}))+'>' + data + '</a>';

                        	return '<a href="#" class="a-koi-search-deudor-component-table">' + data + '</a>';
                        }
                    },
                    {
                        targets: 1,
                        width: '85%',
                        searchable: false
                    },
                    {
                        targets: [2, 3, 4, 5, 6],
                        visible: false,
                        searchable: false
                    }
                ]
            });

            // Modal show
            this.ready();
			this.$modalComponent.modal('show');
		},

		setTercero: function(e) {
			e.preventDefault();
	        var data = this.deudoresSearchTable.row( $(e.currentTarget).parents('tr') ).data();

			this.$inputContent.val( data.deudor_nit );
            this.$inputName.val( data.deudor_nombre );

            this.$inputContent.trigger('change');
            this.$modalComponent.modal('hide');
		},

		search: function(e) {
			e.preventDefault();

		    this.deudoresSearchTable.ajax.reload();
		},

		clear: function(e) {
			e.preventDefault();

			this.$searchNit.val('');
			this.$searchName.val('');

            this.deudoresSearchTable.ajax.reload();
		},

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();
        }
    });


})(jQuery, this, this.document);
