/**
* Class MainPresupuestoAsesorView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainPresupuestoAsesorView = Backbone.View.extend({

        el: '#presupuestoasesor-create',
        template: _.template( ($('#add-presupuesto-tpl').html() || '') ),
        events: {
            'change .change-asesor': 'changeAsesor'
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            // Initialize
            this.$wraperForm = this.$('#render-div-asesor');

            // Reference to fields
            this.$asesor = this.$('#presupuestoasesor_asesor');
            this.$ano = this.$('#presupuestoasesor_ano');
        },

        /**
        * fires libraries js
        */
        ready: function () {
            if( typeof window.initComponent.initInputMask == 'function' )
                    window.initComponent.initInputMask();
        },

        /**
        * Event Create Folder
        */
        changeAsesor: function (e) {
        	var _this = this;

            $.ajax({
                url: window.Misc.urlFull(Route.route('presupuestoasesor.index')),
                type: 'GET',
                data: { 
                	presupuestoasesor_asesor: _this.$asesor.val(),
                	presupuestoasesor_ano: _this.$ano.val()
                },
                beforeSend: function() {
                    window.Misc.setSpinner( _this.el );
                }
            })
            .done(function(resp) {
                window.Misc.removeSpinner( _this.el );
                if(resp.success) {
                    // asesor
                    _this.$wraperForm.html( _this.template( resp ) );
                    _this.ready();
                }
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                window.Misc.removeSpinner( _this.el );
                alertify.error(thrownError);
            });
        }
    });

})(jQuery, this, this.document);
