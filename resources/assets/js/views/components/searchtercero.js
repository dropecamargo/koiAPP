/**
* Class ComponentSearchTerceroView  of Backbone
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ComponentSearchTerceroView = Backbone.View.extend({

      	el: 'body',
        template: _.template( ($('#koi-search-tercero-component-tpl').html() || '') ),

		events: {
			'change input.tercero-koi-component': 'terceroChanged',
            'click .btn-koi-search-tercero-component-table': 'searchTercero',
            'click .btn-search-koi-search-tercero-component': 'search',
            'click .btn-clear-koi-search-tercero-component': 'clear',
            'click .a-koi-search-tercero-component-table': 'setTercero'
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
            this.$searchNit = this.$('#koi_search_tercero_nit');
            this.$searchName = this.$('#koi_search_tercero_nombre');

            this.$tercerosSearchTable = this.$modalComponent.find('#koi-search-tercero-component-table');

            this.$inputContent = this.$("#"+$(e.currentTarget).attr("data-field"));
            this.$wraperConten = this.$("#"+this.$inputContent.attr("data-wrapper"));
            this.$inputName = this.$("#"+this.$inputContent.attr("data-name"));
            this.$btnContact = this.$("#"+this.$inputContent.attr("data-contacto"));
            this.$inputAddress = this.$("#"+this.$inputContent.attr("data-address"));
            this.$inputPuntoVenta = this.$("#"+this.$inputContent.attr("data-punto"));
            this.$inputDeudor = this.$("#"+this.$inputContent.attr("data-deudor"));
            this.$changeIf = this.$inputContent.attr("data-change");
            this.$inputCliente = this.$inputContent.attr("data-cliente");
            this.$inputVendedor = this.$inputContent.attr("data-vendedor");
            this.$inputTecnico = this.$inputContent.attr("data-tecnico");

            this.$concepto = this.$("#"+this.$inputContent.attr("data-concepto"));
            this.$wrap = this.$("#"+this.$inputContent.attr("data-wrap"));

            if (this.$changeIf == "true" && (this.$inputPuntoVenta.val() == ''  && this.$inputPuntoVenta.length > 0)) {
                alertify.error('Por favor ingrese punto de venta antes seleccionar tercero.');
                return;
            }

            this.tercerosSearchTable = this.$tercerosSearchTable.DataTable({
                dom: "<'row'<'col-sm-12'tr>>" +
               		"<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull( Route.route('terceros.index') ),
                    data: function( data ) {
                        data.tercero_nit = _this.$searchNit.val();
                        data.tercero_nombre = _this.$searchName.val();
                        data.cliente = _this.$inputCliente;
                        data.vendedor = _this.$inputVendedor;
                        data.tecnico = _this.$inputTecnico;
                    }
                },

                columns: [
                    { data: 'tercero_nit', name: 'tercero_nit' },
                    { data: 'tercero_nombre', name: 'tercero_nombre' },
                    { data: 'tercero_razonsocial', name: 'tercero_razonsocial'},
                    { data: 'tercero_nombre1', name: 'tercero_nombre1' },
                    { data: 'tercero_nombre2', name: 'tercero_nombre2' },
                    { data: 'tercero_apellido1', name: 'tercero_apellido1' },
                    { data: 'tercero_apellido2', name: 'tercero_apellido2' },
                    { data: 'tercero_direccion', name: 'tercero_direccion' }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '15%',
                        searchable: false,
                        render: function ( data, type, full, row ) {

                            // Render show tercero in dashboard
                            if (_this.$fieldRender == "show")
                                return '<a href='+ window.Misc.urlFull( Route.route('terceros.show', { terceros: full.id}))+'>' + data + '</a>';

                        	return '<a href="#" class="a-koi-search-tercero-component-table">' + data + '</a>';
                        }
                    },
                    {
                        targets: 1,
                        width: '85%',
                        searchable: false
                    },
                    {
                        targets: [2, 3, 4, 5, 6, 7],
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
	        var data = this.tercerosSearchTable.row( $(e.currentTarget).parents('tr') ).data();
			this.$inputContent.val( data.tercero_nit );
            this.$inputName.val( data.tercero_nombre );
            this.$inputAddress.val( data.tercero_direccion );

            if(this.$btnContact.length > 0) {
                this.$btnContact.attr('data-tercero', data.id);
            }

            if(this.$inputDeudor.length > 0) {
                $('#gestiondeudor_deudor').val(null).text('');
                $('#deudor_nombre').val(null).text('');
                this.$inputDeudor.attr('data-tercero', data.id);
            }

            if(this.$concepto.length > 0 && this.$wrap.length > 0 || this.$concepto.length > 0) {
                this.$wrap.removeAttr('hidden');
                this.$concepto.attr('data-tercero', data.id);
                this.$concepto.removeAttr('disabled');
            }

			this.$modalComponent.modal('hide');
            if (this.$changeIf == "true") {
                if (this.$wraperConten.attr('id') == "gestioncobro-create") {
                    this.$inputContent.attr('data-tercero', data.id)
                }
                this.$inputContent.removeClass('tercero-koi-component');
                this.$inputContent.trigger('change');
                this.$inputContent.addClass('tercero-koi-component');
            }
		},

		search: function(e) {
			e.preventDefault();

		    this.tercerosSearchTable.ajax.reload();
		},

		clear: function(e) {
			e.preventDefault();

			this.$searchNit.val('');
			this.$searchName.val('');

            this.tercerosSearchTable.ajax.reload();
		},

		terceroChanged: function(e) {
			var _this = this;
            this.$inputContent = $(e.currentTarget);
			this.$inputName = this.$("#"+$(e.currentTarget).attr("data-name"));
			this.$wraperConten = this.$("#"+$(e.currentTarget).attr("data-wrapper"));
            this.$inputAddress = this.$("#"+this.$inputContent.attr("data-address"));
            this.$changeIf = this.$inputContent.attr("data-change");
            this.$btnContact = this.$("#"+this.$inputContent.attr("data-contacto"));
            this.$inputPuntoVenta = this.$("#"+this.$inputContent.attr("data-punto"));

            this.$concepto = this.$("#"+this.$inputContent.attr("data-concepto"));
            this.$wrap = this.$("#"+this.$inputContent.attr("data-wrap"));


            if(this.$btnContact.length > 0) {
                this.$btnContact.attr('data-tercero', '');
            }
            var tercero = this.$inputContent.val();

            if (this.$changeIf == "true" && (this.$inputPuntoVenta.val() == ''  && this.$inputPuntoVenta.length > 0)) {
                tercero = this.$inputContent.val('');
                alertify.error('Por favor ingrese punto de venta antes seleccionar tercero.');
                return;
            }


            // Before eval clear data
            this.$inputName.val('');
            this.$inputAddress.val('');

            if(!_.isUndefined(tercero) && !_.isNull(tercero) && tercero != '') {
                // Get tercero
                $.ajax({
                    url: window.Misc.urlFull(Route.route('terceros.search')),
                    type: 'GET',
                    data: { tercero_nit: tercero },
                    beforeSend: function() {
                        _this.$inputName.val('');
                        window.Misc.setSpinner( _this.$wraperConten );
                    }
                })
                .done(function(resp) {
                    window.Misc.removeSpinner( _this.$wraperConten );
                    if(resp.success) {
                        if(_this.$concepto.length > 0 && _this.$wrap.length > 0 || _this.$concepto.length > 0) {
                            _this.$wrap.removeAttr('hidden');
                            _this.$concepto.attr('data-tercero', resp.id);
                            _this.$concepto.removeAttr('disabled');
                        }

                        if(!_.isUndefined(resp.tercero_nombre) && !_.isNull(resp.tercero_nombre)){
                            _this.$inputName.val(resp.tercero_nombre);
                        }
                        if(!_.isUndefined(resp.tercero_direccion) && !_.isNull(resp.tercero_direccion)){
                            _this.$inputAddress.val(resp.tercero_direccion);
                        }
                        if(_this.$btnContact.length > 0) {
                            _this.$btnContact.attr('data-tercero', resp.id);
                        }
                    }
	            })
	            .fail(function(jqXHR, ajaxOptions, thrownError) {
	                window.Misc.removeSpinner( _this.$wraperConten );
	                alertify.error(thrownError);
	            });

	     	}
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
