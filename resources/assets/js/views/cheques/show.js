/**
* Class ShowChequeView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ShowChequeView = Backbone.View.extend({

        el: '#content-show',

        events:{
            'click .devolver-cheque': 'devolverCheque',
            'click .anular-cheque': 'anularCheque',
            'submit #form-causal-choise': 'onStoreChequeDevuelto'
        },
        /**
        * Constructor Method
        */
        initialize : function() {
            // Model exist
            if( this.model.id != undefined ) {
                this.detalleChposFechado = new app.DetalleChposFechadoList();

                // Prepare modal causa
                this.$modal = this.$('#modal-causa');

                // Reference views
                this.referenceViews();
            }
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            //detalleChequesView
            this.detalleChequesView = new app.DetalleChequesView( {
                collection: this.detalleChposFechado,
                parameters: {
                    wrapper: this.$('#detail-chposfechado'),
                    edit: false,
                    dataFilter: {
                        'chposfechado2': this.model.get('id')
                    }
               }
            });
        },
        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();
            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();
        },
        /**
        *
        */
        anularCheque: function(e){
            e.preventDefault();
            var _this = this;
            var anularConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: { id: _this.model.get('id') },
                    template: _.template( ($('#cheque-anular-confirm-tpl').html() || '') ),
                    titleConfirm: 'Anular cheque posfechado',
                    onConfirm: function () {
                        // Anular cheque
                        $.ajax({
                            url: window.Misc.urlFull( Route.route('cheques.anular', { cheques: _this.model.get('id') }) ),
                            type: 'GET',
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

                                window.Misc.successRedirect( resp.msg, window.Misc.urlFull(Route.route('cheques.show', { cheques: _this.model.get('id') })) );
                            }
                        })
                        .fail(function(jqXHR, ajaxOptions, thrownError) {
                            window.Misc.removeSpinner( _this.el );
                            alertify.error(thrownError);
                        });
                    }
                }
            });
            anularConfirm.render();
        },
        /*
        *
        */
        devolverCheque: function(e){
            e.preventDefault();
            var _this = this;
            var anularConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: { id: _this.model.get('id') },
                    template: _.template( ($('#cheque-devolver-confirm-tpl').html() || '') ),
                    titleConfirm: 'Devolver cheque posfechado',
                    onConfirm: function () {
                        _this.templateCausal = _.template(($('#koi-select-causa').html() || '') );
                        _this.$modal.find('.inner-title-modal').html('Causal devolucion cheque');
                        _this.$modal.find('.content-modal').empty().html( _this.templateCausal() );
                        _this.$modal.modal('show');
                        _this.ready();

                    }
                }
            });
            anularConfirm.render();
        },
        /*
        *
        */
        onStoreChequeDevuelto: function(e){
            if (!e.isDefaultPrevented()) {
                e.preventDefault();
                var _this = this;
                var data =  window.Misc.formToJson( e.target );
                    data.id = this.model.get('id');
                // Devolver cheque
                $.ajax({
                    url: window.Misc.urlFull( Route.route('chequesdevueltos.store') ),
                    data: data,
                    type: 'POST',
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
                        _this.$modal.modal('hide');
                        window.Misc.successRedirect( resp.msg, window.Misc.urlFull(Route.route('cheques.show', { cheques: _this.model.get('id') })) );
                    }
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    window.Misc.removeSpinner( _this.el );
                    alertify.error(thrownError);
                });
            }
        }
    });
})(jQuery, this, this.document);
