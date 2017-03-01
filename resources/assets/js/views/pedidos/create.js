/**
* Class CreatePedidoView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreatePedidoView = Backbone.View.extend({

        el: '#pedido-create',
        template: _.template( ($('#add-pedido-tpl').html() || '') ),
        events: {
            'click .submit-pedido': 'submitPedido',
            'submit #form-pedido' :'onStore',
            'submit #form-detalle-pedido' :'onStoreDetallePedido'
         },
        parameters: {
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            // Initialize
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            // Attributes
            this.$wraperForm = this.$('#render-form-pedido');

             //Model Exists
            if( this.model.id != undefined ) {
                this.detallePedido = new app.DetallePedidoCollection();
            }
            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /**
        * Event Create Pedido
        */
        onStore: function (e) {

            if (!e.isDefaultPrevented()) {

                e.preventDefault();
                var data = window.Misc.formToJson( e.target );
                this.model.save( data, {patch: true, silent: true} );
            }
        },

        /**
        * Event Create PedidoDetalle
        */
        onStoreDetallePedido:function(e){
            
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );

                this.detallePedido.trigger( 'store', data );
            }
        },

        /*
        * Render View Element
        */
        render: function() {
                        
            var attributes = this.model.toJSON();
            this.$wraperForm.html( this.template(attributes) );
            this.$form = this.$('#form-pedido');
            this.$formdetalle = this.$('#form-detalle-pedido');
            
            // Model exist
            if( this.model.id != undefined ) {

                // Reference views
                this.referenceViews();
            }
            this.ready();
        },

        referenceViews:function(){

            this.detallePedidosView = new app.DetallePedidosView( {
                collection: this.detallePedido,
                parameters: {
                    edit: true,
                    wrapper: this.$('#detalle-pedido'),
                    dataFilter: {
                        'pedido_id': this.model.get('id')
                    }
               }
            });
        },

        /**
        *Event Click to Button
        */
        submitPedido:function(e){
            this.$form.submit();
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initICheck == 'function' )
                window.initComponent.initICheck(); 

            
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();
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

                // Redirect to edit pedido
                Backbone.history.navigate(Route.route('pedidos.edit', { pedidos: resp.id}), { trigger:true });
            }
        }
    });

})(jQuery, this, this.document);
