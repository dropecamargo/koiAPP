/**
* Class ShowFacturapView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ShowFacturapView = Backbone.View.extend({

        el: '#facturap-show',
        events:{
        },

        /**
        * Constructor Method
        */
        initialize : function() {

            // Model exist
            if( this.model.id != undefined ) {
                // Reference collection
                this.detalleFacturap2 = new app.DetalleFacturasp2Collection();
                this.activoFijoList = new app.ActivoFijoList();
                this.detallecuotaProveedor = new app.DetalleFacturap3List();
                this.entradasList = new app.EntradasList();

                this.$templateProveedor = _.template( ($('#show-facturap-cuota-tpl').html() || '') );
                this.$templateDetailEntrada = _.template( ($('#show-entrada-detail-tpl').html() || '') );

                // Reference views
                this.referenceViews();
            }

        },

        /**
        * reference to views
        */
        referenceViews: function () {
            this.detalleFacturap2View = new app.Facturap2DetalleView( {
                collection: this.detalleFacturap2,
                parameters: {
                    wrapper: this.el,
                    edit: false,
                    dataFilter: {
                        'id': this.model.get('id')
                    }
               }
            });

            this.activoFijoListView = new app.ActivosFijosListView( {
                collection: this.activoFijoList,
                parameters: {
                    wrapper: this.el,
                    edit: false,
                    form: this.$('#form-activo-fijo'),
                    dataFilter: {
                        'id': this.model.get('id')
                    }
               }
            });
            // Detalle list factura proveedor
            this.factura3ListView = new app.Facturap3ListView({
                collection: this.detallecuotaProveedor,
                parameters: {
                    wrapper: this.el,
                    edit: false,
                    call: 'tercero',
                    template: this.$templateProveedor,
                    dataFilter: {
                        'facturap': this.model.get('id'),
                    }
                }
            });

            this.entradasListView = new app.EntradasListView( {
                collection: this.entradasList,
                parameters: {
                    wrapper: this.el,
                    edit: false,
                    template: this.$templateDetailEntrada,
                    dataFilter: {
                        'facturap': this.model.get('id')
                    }
               }
            });
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
