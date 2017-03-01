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
            'change .change-asesor': 'changeAsesor',
            'submit #form-presupuestoasesor': 'onStore'
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            // Initialize
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

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

            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();
        },


        /**
        * Event store presupuestoasesor
        */
        onStore: function (e) {
            var _this = this;

            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: window.Misc.urlFull(Route.route('presupuestoasesor.store')),
                    data: data,
                })
                .done(function(resp) {
                    window.Misc.removeSpinner( _this.el );
                    if(resp.success) {
                        alertify.success('Presupuesto actualizado');
                        return;
                    }else{
                        var text = window.Misc.parseErrors(resp.errors);
                        alertify.error(text);
                        return;
                    }
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    window.Misc.removeSpinner( _this.el );
                    alertify.error(thrownError);
                });
            }
        },

        /**
        * Event Create Folder
        */
        changeAsesor: function (e) {
        	var _this = this;

            $.ajax({
                type: 'GET',
                dataType: 'json',
                url: window.Misc.urlFull(Route.route('presupuestoasesor.index')),
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
                }else{
                    var text = window.Misc.parseErrors(resp.errors);
                    alertify.error(text);
                    return;
                }
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                window.Misc.removeSpinner( _this.el );
                alertify.error(thrownError);
            });
        }
    });

})(jQuery, this, this.document);
