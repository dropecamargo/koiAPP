/**
* Class ComponentProductView  of Backbone
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ComponentProductView = Backbone.View.extend({

      	el: 'body',
		events: {
			'change .change-referencia-koi-component': 'referenciaChanged'
		},

        /**
        * Constructor Method
        */
		initialize: function() {
            // Initialize
        },

        referenciaChanged: function(e) {
            var _this = this;
            console.log(e);
        	this.$wraperContent = this.$('#productos-create');
            if(!this.$wraperContent.length) {
	            this.$modalComponent = this.$('#modal-add-resource-component');
	            this.$wraperContent = this.$modalComponent.find('.modal-body');
   			}
            if ( $(e.currentTarget).val() != '') {
                $.ajax({
                    url: window.Misc.urlFull(Route.route('productos.referencia')),
                    type: 'GET',
                    data: { producto_referencia: $(e.currentTarget).val() },
                    beforeSend: function() {
                        window.Misc.setSpinner( _this.$wraperContent );
                    }
                })
                .done(function(resp) {
                    window.Misc.removeSpinner( _this.$wraperContent );
                    if(!resp.success) {
                        $(e.currentTarget).val('');
                        alertify.error(resp.errors);
                    }

                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    window.Misc.removeSpinner( _this.$wraperContent );
                    alertify.error(thrownError);
                });
            }
        },
    });
})(jQuery, this, this.document);
