/**
* Class ShowProductosView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ShowProductoView = Backbone.View.extend({

        el: '#content-show',
        template: _.template( ($('#add-ubicacion-tpl').html() || '') ),
        events: {
            'click .get-series': 'getSeries',
            'click .add-ubicacion': 'addUbicacion',
            'submit #form-ubicacion-component': 'updateComponent'
        },

        /**
        * Constructor Method
        */
        initialize: function() {
            this.prodbodeList = new app.ProdbodeList();
            this.$modalUbicacion = this.$('#modal-ubicacion-component');
        },

        getSeries: function(e){
            e.preventDefault();
            // Model exist
            if( this.prodbodeList.length == 0 ) {
                // Reference views
                this.referenceViews();
            }
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            // Detalle asignaciones list
            this.prodbodeListView = new app.ProdbodeListView({
                collection: this.prodbodeList,
                parameters: {
                    wrapper: this.$('#wrapper-series'),
                    dataFilter: {
                        'producto_id': this.model.get('id')
                    }
                }
            });
        },

        addUbicacion: function(e){
            var _this = this;

            var resourse = {sucursal: _this.$(e.currentTarget).attr('data-sucursal'),
                            nombre: _this.$(e.currentTarget).attr('data-nombre'),
                            serie: _this.$(e.currentTarget).attr('data-serie'),
                            id: _this.$(e.currentTarget).attr('data-id')};

            _this.$modalUbicacion.find('.content-modal').empty().html( _this.template( resourse ) );

            // Open modal
            _this.$modalUbicacion.modal('show');
        },

        updateComponent: function(e){
            var _this = this;
            if (!e.isDefaultPrevented()) {
                e.preventDefault();
                var data = window.Misc.formToJson( e.target );
                var prodbode = this.$('#prodbode_ubicacion1').attr('data-id');

                $.ajax({
                    type: "PUT",
                    url: window.Misc.urlFull(Route.route('productos.prodbode.update', {prodbode: prodbode})),
                    data: {data, prodbode},
                    beforeSend: function() {
                        window.Misc.setSpinner( _this.el );
                    }
                })
                .done(function(resp) {
                    window.Misc.removeSpinner( _this.el );
                    // response success or error
                    var text = resp.success ? '' : resp.errors;
                    if( _.isObject( resp.errors ) ) {
                        text = window.Misc.parseErrors(resp.errors);
                    }

                    if( !resp.success ) {
                        alertify.error(text);
                        return;
                    }

                    _this.$modalUbicacion.modal('hide');
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    window.Misc.removeSpinner( _this.el );
                    alertify.error(thrownError);
                });
            }
        },
    });

})(jQuery, this, this.document);
