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
			'change .change-sucursal-consecutive-koi-component': 'sucursalChange'
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
                
                // Set consecutive
                _this.$consecutive.val( parseInt(consecutive) + 1);
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                window.Misc.removeSpinner( _this.$wrapperContent );
                alertify.error(thrownError);
            });
        }
    });


})(jQuery, this, this.document);