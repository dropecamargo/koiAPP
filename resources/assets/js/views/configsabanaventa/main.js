/**
* Class MainConfigSabanaVentaView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainConfigSabanaVentaView = Backbone.View.extend({
        el: '#configsabanaventa-create',
        template: _.template( ($('#browse-detailconfigsabanaventa-tpl').html() || '') ),
        templateModal: _.template( ($('#configsabana-modal-store-tpl').html() || '') ),
        templateOnConfirm:_.template( ($('#configsabana-remove-confirm-tpl').html() || '') ),
        events: {
            'click td.click-tree': 'captureDetail',
            'click .remove-item': 'removeOne',
            'click .add-item' : 'addItem',
            // 'submit #form-configsabana-component' : 'onStore'
        },
        /**
        * Constructor Method
        */
        initialize : function() {
            // Reference fields
            this.attributes = {};
            this.$modal = $('#modal-configsabana-component');
            this.$formModal = $('#form-configsabana-component');
            this.call = '';
            this.$configSabanaSearchTable = this.$('#configsabanaventa-search-table');
            this.configSabanaSearchTable = this.$configSabanaSearchTable.DataTable({
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull( Route.route('configsabana.index') ),
                    data: function( data ) {
                        data.datatables = true;
                    }
                },
                columns: [
                    {
                        "className":'click-tree text-center',
                        "orderable":false,
                        "data": null,
                        "defaultContent": ''
                    },
                    { data: 'configsabanaventa_agrupacion_nombre', name: 'configsabanaventa_agrupacion_nombre' },
                ],
                order: [[1, 'asc']],
                columnDefs: [
                    {
                        targets: 0,
                        width: '5%',
                        searchable: false,
                        render: function ( data, type, full, row ) {
                            return '<a class="btn btn-xs"><span><i class="fa fa-eye"></i></span></a>&nbsp;&nbsp;'
                        }
                    },
                ]
			});
        },
        /**
        * Add event listener for opening and closing details
        */
        captureDetail: function(e){
            // `data` is the original data object for the row
            e.preventDefault();
            var tr = $(e.currentTarget).closest('tr');
            var row = this.configSabanaSearchTable.row( tr );

            if ( row.child.isShown() ) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
            }else {
                // Open this row
                this.attributes = row.data();
                row.child( this.renderDetail(this.attributes.configsabanaventa_agrupacion) ).show();
                tr.addClass('shown');
            }
        },
        /**
        * Render template
        * @param id de agrupacion
        */
        renderDetail: function (attributes){
            var _this = this;
            var div = $('<div/>').addClass( 'loading' ).text( 'Cargando...' );
            $.ajax( {
                url: window.Misc.urlFull( Route.route('configsabana.index') ),
                data: {
                    agrupacion: attributes
                },
                dataType: 'json',
                success: function ( resp ) {
                    resp.agrupacion = attributes.configsabanaventa_agrupacion
                    div.html( _this.template( resp ) ).removeClass( 'loading' );
                },
                error: function (resp){
                    alertify.error(resp.responseJSON);
                    return;
                }
            });
            return div;
        },
        /*
        *
        */
        addItem: function(e){
            e.preventDefault();

            var title = 'Creando ';
            this.$modal.find('.content-modal').html( this.templateModal() );
            this.call = this.$(e.currentTarget).attr('data-call');
            // Define tittulo del modal
            if (this.call === 'add-agrupation') {
                title += 'agrupación' ;
            }else if (this.call === 'add-group') {
                title += 'grupo' ;
            }else if (this.call === 'add-unification') {
                title += 'unificación' ;
            }else if (this.call === 'add-line') {
                title += 'linea' ;
            }
            // Change modal title
            this.$modal.find('.inner-title-modal').html( title );

            this.$modal.modal('show');
            this.ready();
            // Add event listener for opening and closing details
            _this = this;
            this.$formModal.on('click', '.submit-configsabana', function () {
                _this.onStore();
            } );
        },
        /*
        * On store item
        */
        onStore: function(){
            var data = window.Misc.formToJson( this.$formModal )
            console.log(data);
        },
        /*
        * Remove view and item the config
        */
        removeOne: function (e){
            e.preventDefault();
            var _this = this;
            _this.$tableDetail = _this.$('#table-detailconfigsabanaventa');
            _this.$tr = _this.$tableDetail.find( '#'+ $(e.currentTarget).attr('data-call') + $(e.currentTarget).attr('data-resource') );
            var cancelConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: { line: $(e.currentTarget).attr('data-name') },
                    template: _this.templateOnConfirm,
                    titleConfirm: 'Eliminar ítem de la configuración sabana de ventas ',
                    onConfirm: function () {
                        $.ajax( {
                            url: window.Misc.urlFull( Route.route('configsabana.destroy', { configsabana: $(e.currentTarget).attr('data-resource')  }) ),
                            type: 'DELETE',
                            dataType: 'json',
                            success: function ( resp ) {
                                _this.$tr.empty();

                                alertify.success(resp);
                                return;
                            },
                            error: function (resp){
                                alertify.error(resp.responseJSON);
                                return;
                            }
                        });
                    }
                }
            });
            cancelConfirm.render();
        },
        /**
        * fires libraries js
        */
        ready: function () {
            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();

            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();

            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();
        }
    });

})(jQuery, this, this.document);
