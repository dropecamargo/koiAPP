/**
* Class ComponentConsecutiveView  of Backbone
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ComponentConsecutiveView = Backbone.View.extend({

      	el: 'body',
		events: {
            'change .change-sucursal-consecutive-koi-component': 'sucursalChange',
            'change .change-regional-consecutive-koi-component': 'regionalChange',
            'change .change-puntoventa-consecutive-koi-component': 'puntoVentaChange'
		},

        /**
        * Constructor Method
        */
		initialize: function() {
			// Initialize
		},

        sucursalChange: function(e) {
            var _this = this;
        		documents = $(e.currentTarget).attr("data-document");
    			sucursal = $(e.currentTarget).val();

            // Reference to fields
            this.$consecutive = $("#"+$(e.currentTarget).attr("data-field"));
        	this.$wrapperContent = $("#"+$(e.currentTarget).attr("data-wrapper"));

            if (sucursal != '') {

                $.ajax({
                    url: window.Misc.urlFull(Route.route('sucursales.show', {sucursales: sucursal})),
                    type: 'GET',
                    beforeSend: function() {
                        window.Misc.setSpinner( _this.$wrapperContent );
                    }
                })
                .done(function(resp) {
                    window.Misc.removeSpinner( _this.$wrapperContent );
                    
                    // Eval consecutive
                    var consecutive = 0;
                    if(documents == 'pedido') consecutive = resp.sucursal_pedn;
                    if(documents == 'ajuste') consecutive = resp.sucursal_ajus;
                    if(documents == 'traslados') consecutive = resp.sucursal_tras;
                    if(documents == 'pedidoc') consecutive = resp.sucursal_pedidoc;
                    if(documents == 'devolucion') consecutive = resp.sucursal_devo;
                    if(documents == 'trasladosubicaciones') consecutive = resp.sucursal_trau;
                    if(documents == 'recibos') consecutive = resp.regional_reci;
                    if(documents == 'notas') consecutive = resp.regional_nota;
                    if(documents == 'ajustec') consecutive = resp.regional_ajuc;
                    if(documents == 'anticipo') consecutive = resp.regional_anti;
                    if(documents == 'chequepos') consecutive = resp.regional_chp;
                    if(documents == 'orden') consecutive = resp.regional_ord;

                    // Set consecutive
                    _this.$consecutive.val( parseInt(consecutive) + 1);
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    window.Misc.removeSpinner( _this.$wrapperContent );
                    alertify.error(thrownError);
                });
            }
        },
        puntoVentaChange: function(e){
            var _this = this;
                puntoVenta = $(e.currentTarget).val();

            // Reference to fields
            this.$consecutive = $("#"+$(e.currentTarget).attr("data-field"));
            this.$wrapperContent = $("#"+$(e.currentTarget).attr("data-wrapper"));

            if (puntoVenta != '') {

                $.ajax({
                    url: window.Misc.urlFull(Route.route('puntosventa.show', {puntosventa: puntoVenta})),
                    type: 'GET',
                    beforeSend: function() {
                        window.Misc.setSpinner( _this.$wrapperContent );
                    }
                })
                .done(function(resp) {
                    window.Misc.removeSpinner( _this.$wrapperContent );
                    // Eval consecutive
                    var consecutive = 0;
                    consecutive = resp.puntoventa_numero;
                    
                    // Set consecutive
                    _this.$consecutive.val( parseInt(consecutive) + 1);
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    window.Misc.removeSpinner( _this.$wrapperContent );
                    alertify.error(thrownError);
                });
            }
        },
        regionalChange: function (e){
            var _this = this;
                documents = $(e.currentTarget).attr("data-document");
                regional = $(e.currentTarget).val();

            // Reference to fields
            this.$consecutive = $("#"+$(e.currentTarget).attr("data-field"));
            this.$wrapperContent = $("#"+$(e.currentTarget).attr("data-wrapper"));

            if (regional != '') {

                $.ajax({
                    url: window.Misc.urlFull(Route.route('regionales.show', {regionales: regional})),
                    type: 'GET',
                    beforeSend: function() {
                        window.Misc.setSpinner( _this.$wrapperContent );
                    }
                })
                .done(function(resp) {
                    window.Misc.removeSpinner( _this.$wrapperContent );
                    // Eval consecutive
                    var consecutive = 0;

                    if(documents == 'facturap') consecutive = resp.regional_fpro;
                    if(documents == 'ajustep') consecutive = resp.regional_ajup;

                    // Set consecutive
                    _this.$consecutive.val( parseInt(consecutive) + 1);
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    window.Misc.removeSpinner( _this.$wrapperContent );
                    alertify.error(thrownError);
                });
            }
        }

    });


})(jQuery, this, this.document);
