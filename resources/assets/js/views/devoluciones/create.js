/**
* Class CreateDevolucionView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateDevolucionView = Backbone.View.extend({

        el: '#devolucion-create',
        template: _.template(($('#add-devoluciones-tpl').html() || '') ),

        events: {
            'click .submit-devolucion' : 'submitForm',
            'submit #form-devolucion1' : 'onStore',
            'change #devolucion1_tercero' : 'referenceView', 
            'change input.change-cant-devo' : 'cantidadDevolucion', 
        },
        parameters: {
        },

        /**
        * Constructor Method
        */
        initialize : function() {
           
            // Attributes
            this.$wraperForm = this.$('#render-form-devolucion');

            this.detalleDevolucion = new app.DevolucionDetalleCollection();


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

            this.$form = this.$('#form-devolucion1');

        },
        /**
        * Event submit devolucion1
        */
        submitForm: function (e) {
            this.$form.submit();
        },

        /**
        * Event Create devoluciones
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();
                var data = $.extend({}, window.Misc.formToJson( e.target ), this.detalleDevolucion.totalize());
                    data.devolucion2 = this.detalleDevolucion.toJSON();
                this.model.save( data, {patch: true, silent: true} );
            }   
        },  
        /**
        * Reference view collection
        */
        referenceView:function(e, id){
            e.preventDefault();
            this.detalleDevolucionView = new app.DevolucionDetalle2View( {
                collection: this.detalleDevolucion,
                parameters: {
                    wrapper: this.el,
                    edit: true,
                    dataFilter: {
                        'id_factura2': id
                    }
                }
            }); 
        },

        /**
        *
        */
        cantidadDevolucion: function(e){
            e.preventDefault();
            //reference Totales
            this.$total = this.$('#total');
            this.$tdevueltas = this.$('#total_devueltas');
            this.$cantidad = this.$(e.currentTarget);

            var id = (this.$cantidad.attr('id')).split('_');
            var item = this.detalleDevolucion.ValidCantidad(this.$cantidad.val(),id[2]);
            if (!item.success) {
                alertify.error(item.error);
                return;
            }
            this.$totalItem = this.$('#total_'+id[2]);
            this.$totalItem.empty().html(window.Misc.currency(item.total) );
            this.$total.empty().html(window.Misc.currency(item.totales.devolucion1_bruto) );
            this.$tdevueltas.empty().html( item.totales.devueltasTotal );

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
            window.Misc.redirect( window.Misc.urlFull( Route.route('devoluciones.show', { devoluciones: resp.id})) );

        }
    });

})(jQuery, this, this.document);
