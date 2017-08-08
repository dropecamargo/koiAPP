/**
* Class EditFacturapView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.EditFacturapView = Backbone.View.extend({

        el: '#facturap-create',
        template: _.template( ($('#add-facturap-tpl').html() || '') ),
        events: {
            'click .submit-facturap': 'submitFormFacturap', 
            'submit #form-facturap' :'onStore',

            'submit #form-facturap2-impuesto': 'onStoreFacturap2',
            'submit #form-facturap2-retefuente': 'onStoreFacturap2',

            'change #facturap2_impuesto': 'onChangeImpuesto',
            'change #facturap2_retefuente': 'onChangeRetefuente'
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            
            // Reference collection
            this.detalleFacturap2 = new app.DetalleFacturasp2Collection();

            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );            
        },


        /*
        * Render View Element
        */
        render: function() {
            var attributes = this.model.toJSON();
                attributes.edit = true;
            this.$el.html( this.template(attributes) );

            this.$form = this.$('#form-facturap');

            // Spinner
            this.spinner = this.$('#spinner-main');

            //Reference views
            this.referenceViews();

            this.ready();
        },
        /*
        * Reference views
        */
        referenceViews:function(){ 
            this.detalleFacturap2View = new app.Facturap2DetalleView( {
                collection: this.detalleFacturap2,
                parameters: {
                    wrapper: this.el,
                    edit: true,
                    dataFilter: {
                        'id': this.model.get('id')
                    }
               }
            });
        },
        /**
        *Event Click to Button from orden
        */
        submitFormFacturap:function(e){
            this.$form.submit();
        },

        /**
        * Event Create cotizacion
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                // Prepare global data
                var data = window.Misc.formToJson( e.target );
                this.model.save( data, {patch: true, silent: true} );
            }
        },
        /**
        * Store facturap2
        */
        onStoreFacturap2:function(e){
            if (!e.isDefaultPrevented()) {
                e.preventDefault();
                var data = window.Misc.formToJson( e.target ) ;
                    data.facturap1 = this.model.get('id');
                this.detalleFacturap2.trigger( 'store', data);
            }
        },
        /**
        *  Change for get porcentage y set valor with impuesto
        */
        onChangeImpuesto: function (e) {
            e.preventDefault();
            var _this = this;
            if (_this.$(e.target).val() != '') {
                // Impuesto
                $.ajax({
                    url: window.Misc.urlFull( Route.route( 'impuestos.show',{impuestos: _this.$(e.target).val()} ) ),
                    type: 'GET',
                    beforeSend: function() {
                        window.Misc.setSpinner( _this.spinner );
                    }
                })
                .done(function(resp) {
                    window.Misc.removeSpinner( _this.spinner );
                    // Eval porcentage
                    var porcentage = resp.impuesto_porcentaje;
                    _this.$('#facturap2_impuesto_porcentaje').val(porcentage);
                    _this.$('#facturap2_base_impuesto').val((porcentage/100)  * _this.model.get('facturap1_base'));
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    window.Misc.removeSpinner( _this.spinner );
                    alertify.error(thrownError);
                });
            }
        },
        /**
        *  Change for get porcentage y set valor with retefuente
        */
        onChangeRetefuente: function (e) {
            e.preventDefault();
            var _this = this;

            if (_this.$(e.target).val() != '') {
                // Retefuente
                $.ajax({
                    url: window.Misc.urlFull( Route.route( 'retefuentes.show',{retefuentes: _this.$(e.target).val()} ) ),
                    type: 'GET',
                    beforeSend: function() {
                        window.Misc.setSpinner( _this.spinner );
                    }
                })
                .done(function(resp) {
                    window.Misc.removeSpinner( _this.spinner );
                    // Eval porcentage
                    var porcentage = (_this.model.get('tercero_persona') == 'J' ) ? resp.retefuente_tarifa_juridico : resp.retefuente_tarifa_natural;
                    _this.$('#facturap2_retefuente_porcentaje').val(porcentage);
                    _this.$('#facturap2_base_retefuente').val((porcentage/100) * _this.model.get('facturap1_base'));
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    window.Misc.removeSpinner( _this.spinner );
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

            if( typeof window.initComponent.initICheck == 'function' )
                window.initComponent.initICheck();

            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();

            if( typeof window.initComponent.initDatePicker == 'function' )
                window.initComponent.initDatePicker();

            if( typeof window.initComponent.initInputMask == 'function' )
                window.initComponent.initInputMask();

            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();

            if( typeof window.initComponent.initTimePicker == 'function' )
                window.initComponent.initTimePicker();
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (model, xhr, opts) {
            window.Misc.setSpinner( this.spinner );
        },

        /**
        * Response of the server
        */
        responseServer: function ( model, resp, opts ) {
            window.Misc.removeSpinner( this.spinner );

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

				// Redirect to show view                
				window.Misc.redirect( window.Misc.urlFull( Route.route('facturasp.show', { facturasp: resp.id}) ) );
            }
        }
    });

})(jQuery, this, this.document);
