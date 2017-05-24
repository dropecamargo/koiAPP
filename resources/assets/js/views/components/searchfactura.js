/**
* Class ComponentSearchFacturaView of Backbone
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ComponentSearchFacturaView = Backbone.View.extend({

        el: 'body',
        template: _.template( ($('#koi-search-producto-component-tpl').html() || '') ),

        events: {
            'change input.factura-koi-component': 'FacturaChanged',
        },

        /**
        * Constructor Method
        */
        initialize: function() {
            // Initialize
        },

        FacturaChanged: function(e) {
            var _this = this;
            this.$inputContent = $(e.currentTarget);
            this.$wraperConten = this.$("#"+$(e.currentTarget).attr("data-wrapper"));
            this.$inputSucursal = this.$("#"+$(e.currentTarget).attr("data-sucursal"));       
            this.$inputName = this.$("#"+$(e.currentTarget).attr("data-name"));       
            this.$inputNit = this.$("#"+$(e.currentTarget).attr("data-nit"));       
   
            var factura = this.$inputContent.val();
                sucursal = this.$inputSucursal.val();

            if ( sucursal == '' ) {
                this.$inputContent.val('');
                alertify.error('Por favor seleccione sucursal antes de buscar una factura');
                return;
            }
            if(!_.isUndefined(factura) && !_.isNull(factura) && factura != '') {
                // Get Producto
                $.ajax({
                    url: window.Misc.urlFull(Route.route('facturas.search')),
                    type: 'GET',
                    data: { factura_numero: factura,
                            factura_sucursal:sucursal },
                    beforeSend: function() {
                        window.Misc.setSpinner( _this.$wraperConten );
                    }
                })
                .done(function(resp) {
                    window.Misc.removeSpinner( _this.$wraperConten );
                    
                    if(resp.success) {
                        if(!_.isUndefined(resp.cliente) && !_.isNull(resp.cliente)){
                            _this.$inputName.val(resp.cliente);
                        }   
                        if(!_.isUndefined(resp.nit) && !_.isNull(resp.nit)){
                            _this.$inputNit.val(resp.nit);
                        }
                        _this.$inputNit .trigger('change',[resp.id]);
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
