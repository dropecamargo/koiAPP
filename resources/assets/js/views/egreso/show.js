/**
* Class ShowEgresoView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ShowEgresoView = Backbone.View.extend({

        el: '#egreso-show',
        events:{
            'click .anular-egreso': 'anularEgreso',
            'click .export-egreso': 'exportEgreso'
        },

        /**
        * Constructor Method
        */
        initialize : function() {

            // Model exist
            if( this.model.id != undefined ) {

                // Collections
                this.detalleEgreso = new app.DetalleEgresoList();

                // Reference views
                this.referenceViews();
            }

        },

        /**
        * reference to views
        */
        referenceViews: function () {

            this.detalleEgresoView = new app.DetalleEgresosView( {
                collection: this.detalleEgreso,
                parameters: {
                    wrapper: this.el,
                    edit: false,
                    dataFilter: {
                        'id': this.model.get('id'),
                    }
               }
            });
        },
        /*
        * Redirect export pdf
        */
        exportEgreso:function(e){
            e.preventDefault();

            // Redirect to pdf
            window.open( window.Misc.urlFull( Route.route('egresos.exportar', { egresos: this.model.get('id') })) );
        },
        /*
        * Redirect anular factura
        */  
        anularEgreso:function(e){
            e.preventDefault();
            var _this = this;
            var anularConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: { id: _this.model.get('id') },
                    template: _.template( ($('#egreso-anular-confirm-tpl').html() || '') ),
                    titleConfirm: 'Anular egreso',
                    onConfirm: function () {
                        // Anular factura
                        $.ajax({
                            url: window.Misc.urlFull( Route.route('egresos.anular', { egresos: _this.model.get('id') }) ),
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

                                window.Misc.successRedirect( resp.msg, window.Misc.urlFull(Route.route('egresos.show', { egresos: _this.model.get('id') })) );
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
        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initICheck == 'function' )
                window.initComponent.initICheck(); 

            if( typeof window.initComponent.initInputMask == 'function' )
                window.initComponent.initInputMask();
            
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();
            
            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();
            
            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();

            if( typeof window.initComponent.initDatePicker == 'function' )
                window.initComponent.initDatePicker();
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (model, xhr, opts) {
            window.Misc.setSpinner( this.el );
            
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            window.Misc.removeSpinner( this.el );
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
               
            }
        }
    });

})(jQuery, this, this.document);
