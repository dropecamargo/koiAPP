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
        events: {
            'click td.click-tree': 'captureDetail',
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            this.items = {};
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
                    { data: 'configsabanaventa_unificacion_nombre', name: 'configsabanaventa_unificacion_nombre' },
                    { data: 'configsabanaventa_grupo_nombre', name: 'configsabanaventa_grupo_nombre'},
                    { data: 'configsabanaventa_grupo_nombre', name: 'configsabanaventa_grupo_nombre'}
                ],
                order: [[1, 'asc']],
                columnDefs: [
                    {
                        targets: 0,
                        width: '5%',
                        render: function ( data, type, full, row ) {
                            return '<a class="btn btn-xs"><span><i class="fa fa-eye"></i></span></a>&nbsp;&nbsp;'
                        }
                    },
                    {
                        targets: [2,3,4],
                        visible: false,
                    },
                ]
			});
        },
        // Add event listener for opening and closing details
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
                this.renderDetail(tr, row)
            }
        },
        renderDetail: function (tr, row){
            var _this = this;

            var data = row.data();
            var agrupacion = data.configsabanaventa_agrupacion;
            if (!_.isUndefined(agrupacion) ) {

            }
            $.ajax({
                type: "GET",
                url: window.Misc.urlFull(Route.route('configsabana.index')),
                data: {agrupacion: agrupacion},
                beforeSend: function() {
                    window.Misc.setSpinner( _this.el );
                }
            })
            .done(function(resp) {
                window.Misc.removeSpinner( _this.el );
                if(!_.isUndefined(resp.success)) {
                    // response success or error
                    var text = resp.success ? '' : resp.errors;
                    if( _.isObject( resp.errors ) ) {
                        text = window.Misc.parseErrors(resp.errors);
                    }

                    if( !resp.success ) {
                        alertify.error(text);
                        return;
                    }
                    row.child(_this.referenceView(resp.data)).show();
                    tr.addClass('shown');
                }
            })
        },
        referenceView: function(e){
            resp = e;
            return this.template(resp)
        }
    });

})(jQuery, this, this.document);
