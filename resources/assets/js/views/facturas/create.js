/**
* Class CreateFacturaView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateFacturaView = Backbone.View.extend({

        el: '#factura-create',
        template: _.template(($('#add-facturas-tpl').html() || '') ),

        events: {
            'click .submit-factura' : 'submitForm',
            'change #factura1_pedido' : 'referenceViewCollection',
            'submit #form-factura1' :'onStore',
            'click .a-click-modals-lotes-koi': 'renderModals',
        },
        parameters: {
        },

        /**
        * Constructor Method
        */
        initialize : function() {
           
            // Attributes
            this.$wraperForm = this.$('#render-form-factura');

            this.detalleFactura = new app.DetalleFactura2Collection();

            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );            
            
            this.ready(); 
        },
        /*
        * Render View Element
        */
        render: function() {
            var attributes = this.model.toJSON();
            this.$wraperForm.html( this.template(attributes) );

            this.$form = this.$('#form-factura1');

        },
        /**
        * Event submit factura1
        */
        submitForm: function (e) {
            this.$form.submit();
        },
        /*
        *Reference fetch
        */
        referenceViewCollection: function(e, data){
            e.preventDefault();
            this.detalleFacturaView = new app.FacturaDetalle2View( {
                collection: this.detalleFactura,
                parameters: {
                    wrapper: this.el,
                    edit: true,
                    dataFilter: {
                        'id_pedido': data
                    }
               }
            }); 
        },
        /**
        * Event Create facturas
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();
                var data = $.extend({}, window.Misc.formToJson( e.target ) , this.detalleFactura.totalize());
                    data.factura2 = this.detalleFactura.toJSON();
                this.model.save( data, {patch: true, silent: true} );
            }   
        },  
        renderModals:function(e){
            e.preventDefault();
            var model = _.find(this.detalleFactura.models, function(item) {
                return item.get('id') == this.$(e.currentTarget).attr('data-id');
            });
            var data = {}; 
                data.producto_serie = model.get('producto_serie');
                data.producto_nombre = model.get('producto_nombre');
                data.tipo = 'S';
                data.producto_id = model.get('producto_id');
                data.sucursal = this.$('#factura1_sucursal').val();
            window.Misc.evaluateActionsInventory({
                'data': data,
                'wrap': this.$el,
                'callback': (function (_this) {
                    return function ( action , tipo)
                    {      
                        // Open InventarioActionView
                        if ( _this.inventarioActionView instanceof Backbone.View ){
                            _this.inventarioActionView.stopListening();
                            _this.inventarioActionView.undelegateEvents();
                        }

                        _this.inventarioActionView = new app.InventarioActionView({
                            model: _this.model,
                            collection: _this.detalleFactura,
                            parameters: {
                                data: data,
                                action: action,
                                tipo: tipo
                            }
                        });
                        _this.inventarioActionView.render();
                    }
                })(this)
            });  
        },
        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            
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
            window.Misc.redirect( window.Misc.urlFull( Route.route('facturas.index')) );
        }
    });

})(jQuery, this, this.document);
