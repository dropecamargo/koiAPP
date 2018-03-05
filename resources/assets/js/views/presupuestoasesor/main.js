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
            'click .click-btn-search': 'search',
            'click .click-btn-clear': 'clear',
            'submit #form-presupuestoasesor': 'onStore',
            'change .change-input-presupuesto': 'changePresupuesto'
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            // Initialize
            this.$form = this.$('#form-presupuestoasesor');
            this.$wraperForm = this.$('#render-div-asesor');

            // Reference to fields
            this.$asesor = this.$('#presupuestoasesor_asesor');
            this.$linea = this.$('#presupuestoasesor_linea');
            this.$ano = this.$('#presupuestoasesor_ano');

            this.meses = {};
            this.regionales = {};
        },

        /**
        * Change input presupuesto
        */
        changePresupuesto: function (e) {
            var mes = $(e.currentTarget).attr("data-mes"),
                regional = $(e.currentTarget).attr("data-regional");

            // Total linea
            this.totalRegional(regional);

            // Total meses
            this.totalMes(mes);
        },

        totalRegional: function(regional) {
            var total = 0;
            _.each(this.meses, function(name, month) {
                    total += parseFloat( this.$('#presupuestoasesor_valor_' + month + '_' + regional).inputmask('unmaskedvalue') );
            });
            this.$('#presupuestoasesor_total_regional_' + regional).html( window.Misc.currency(total) );
        },

        totalMes: function(mes) {
            var total = 0;
            _.each(this.regionales, function(regional) {
                total += parseFloat( this.$('#presupuestoasesor_valor_' + mes + '_' + regional.id).inputmask('unmaskedvalue') );
            });
            this.$('#presupuestoasesor_total_mes_' + mes).html( window.Misc.currency(total) );
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
                    url: window.Misc.urlFull(Route.route('presupuestoasesor.store')),
                    data: data,
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

                        alertify.success( resp.msg );
                    }
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    window.Misc.removeSpinner( _this.el );
                    alertify.error(thrownError);
                });
            }
        },

        /**
        * Event click search
        */
        search: function (e) {
        	var _this = this;

            if ( _this.$form.validator('validate').has('.has-error').length == 1)
                return;

            $.ajax({
                type: 'GET',
                url: window.Misc.urlFull(Route.route('presupuestoasesor.index')),
                data: {
                    presupuestoasesor_asesor: _this.$asesor.val(),
                    presupuestoasesor_linea: _this.$linea.val(),
                    presupuestoasesor_ano: _this.$ano.val()
                },
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

                    _this.meses = resp.meses;
                    _this.regionales = resp.regionales;

                    // asesor
                    _this.$wraperForm.html( _this.template( resp ) );
                    _this.ready();
                }
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                window.Misc.removeSpinner( _this.el );
                alertify.error(thrownError);
            });
        },
        clear: function(e){
            e.preventDefault();

            // Clear fields
            this.$wraperForm.html('');
            this.$asesor.val(null).trigger('change');
            this.$linea.val(null).trigger('change');
            this.$ano.val(null).trigger('change');
        },
        /**
        * fires libraries js
        */
        ready: function () {
            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();

            if( typeof window.initComponent.initInputMask == 'function' )
                window.initComponent.initInputMask();

            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();
        }
    });

})(jQuery, this, this.document);
