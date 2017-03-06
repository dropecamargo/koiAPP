/**
* Class EditPedidoView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.EditPedidoView = Backbone.View.extend({
        el: '#pedido-create',
        template: _.template(($('#add-pedido-tpl').html() || '') ),
        events: {
            'click .submit-pedido' :'submitPedido',
            'submit #form-pedido' :'onStore',
            'submit #form-detalle-pedido' :'onStoreDetalle',
        },
        parameters: {
        },

        /**
        * Constructor Method
        */
        initialize : function() {
           
            // Attributes
            this.$wraperForm = this.$('#render-form-pedido');
            
            this.detallePedido = new app.DetallePedidoCollection();
            
            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /**
        * Render View Element
        */
        render: function() {
                        
            var attributes = this.model.toJSON();
            attributes.edit = true;
            this.$wraperForm.html( this.template(attributes) );
            this.$form = this.$('#form-pedido');
            this.$formItem = this.$('#form-detalle-pedido');

            // Reference views
            this.referenceViews();
            
            this.ready();
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
        },


        /**
        * reference to views
        */
        referenceViews:function(){ 

            this.detallePedidosView = new app.DetallePedidosView( {
                collection: this.detallePedido,
                parameters: {
                    edit: true,
                    wrapper: this.el,
                    dataFilter: {
                        'pedido_id': this.model.get('id')
                    }
               }
            });
        },

        /**
        * Event submit Asiento
        */
        submitPedido: function (e) {
            this.$form.submit();
        },

        /**
        * Event Create Pedido
        */
        onStore: function (e) {

            if (!e.isDefaultPrevented()) {
                e.preventDefault();
                var data = window.Misc.formToJson( e.target );
                data.pedido_id = this.model.get('id');  
                this.model.save( data, {patch: true, silent: true} );
            }
        },
        /**
        * Event Create DetallePedido
        */
        onStoreDetalle: function (e) {

            if (!e.isDefaultPrevented()) {
                e.preventDefault();
                var data = window.Misc.formToJson( e.target );
                this.detallePedido.trigger('store' , data);
            }
        }

    });

})(jQuery, this, this.document);