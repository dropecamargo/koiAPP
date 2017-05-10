/**
* Class PedidocDetalleView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.PedidocDetalleView = Backbone.View.extend({

        el: '#browse-detalle-pedidoc-list',
        events: {
            'click .item-detalleajuste-remove': 'removeOne'
        },
        parameters: {
            wrapper: null,
            edit: false,
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize : function(opts){

            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            //Init Attributes
            this.confCollection = { reset: true, data: {} };

            // References th totalize
            this.$costo = this.$('#precio-product');
            this.$descuento = this.$('#descuento-product');
            this.$iva = this.$('#iva-product');
            this.$total = this.$('#totalize-product');

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'store', this.storeOne );
            this.listenTo( this.collection, 'sync', this.responseServer);

            if( !_.isUndefined(this.parameters.dataFilter.id) && !_.isNull(this.parameters.dataFilter.id) ){
                this.confCollection.data.id = this.parameters.dataFilter.id;
                this.collection.fetch( this.confCollection );
            }
        },

        /*
        * Render View Element
        */
        render: function() {

        },

        /**
        * Render view contact by model
        * @param Object detallePedidocModel Model instance
        */
        addOne: function (detallePedidocModel) {
            var view = new app.DetallePedidoscItemView({
                model: detallePedidocModel,
                parameters: {
                    edit: this.parameters.edit
                }
            });
            detallePedidocModel.view = view;
            this.$el.append( view.render().el );

            //setter subtotal de registro 
            this.setterModel(detallePedidocModel);
            //totalize actually in collection
            this.totalize();
        },

        /**
        * Render all view Marketplace of the collection
        */
        addAll: function () {
            this.$el.find('tbody').html('');
            this.collection.forEach( this.addOne, this );
        },

        /**
        * stores detallePedido
        * @param form element
        */
        storeOne: function (form) {          
            var _this = this,
                data = window.Misc.formToJson( form );
                data.id = this.parameters.dataFilter.id;
            
            var valid = this.collection.validarExists(data);
            if(!valid.success){
                this.totalize();
                return;
            }
            // Set Spinner
            window.Misc.setSpinner( this.parameters.wrapper );
            
            // Add model in collection
            var detallePedidocModel = new app.PedidoscDetalleModel();
            detallePedidocModel.save(data, {
                success : function(model, resp) {
                    if(!_.isUndefined(resp.success)) {
                        window.Misc.removeSpinner( _this.parameters.wrapper );

                        // response success or error
                        var text = resp.success ? '' : resp.errors;
                        if( _.isObject( resp.errors ) ) {
                            text = window.Misc.parseErrors(resp.errors);
                        }

                        if( !resp.success ) {
                            alertify.error(text);
                            return;
                        }

                        // Add model in collection
                        _this.collection.add(model);
                    }
                },
                error : function(model, error) {
                    window.Misc.removeSpinner( _this.parameters.wrapper );
                    alertify.error(error.statusText)
                }
            });
        },
        
        /**
        *Render totales the collection
        */
        totalize: function(){
            var data = this.collection.totalize();
            this.$costo.empty().html(window.Misc.currency(data.pedidoc1_bruto) );
            this.$descuento.empty().html(window.Misc.currency(data.pedidoc1_descuento) );
            this.$iva.empty().html(window.Misc.currency(data.pedidoc1_iva) );
            this.$total.empty().html(window.Misc.currency(data.pedidoc1_total) );
        },
        /**
        *setter pedidoc_subtotal the model
        */
        setterModel: function(model){
            var iva = model.get('pedidoc2_iva_porcentaje')  / 100;
                precio = parseFloat(model.get('pedidoc2_precio_venta')) * iva * parseFloat(model.get('pedidoc2_cantidad') ) ;
                precio = precio - (parseFloat(model.get('pedidoc2_descuento_valor'))) * parseFloat(model.get('pedidoc2_cantidad') ) ;
                costo = (parseFloat(model.get('pedidoc2_costo'))) * parseFloat(model.get('pedidoc2_cantidad'));
            model.set('pedidoc2_subtotal', (costo + precio));
            model.set('pedidoc2_iva_valor', (parseFloat(model.get('pedidoc2_precio_venta')) * iva));
        },
        /**
        * Event remove item
        */
        removeOne: function (e) {
            e.preventDefault(); 
            var resource = $(e.currentTarget).attr("data-resource");
                model = this.collection.get(resource);

            if ( model instanceof Backbone.Model ) {
                model.view.remove();
                this.collection.remove(model);

                // totalize actually in collection
                this.totalize();
            }
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {
            window.Misc.setSpinner( this.el );
        },

        /**
        * response of the server
        */
        responseServer: function ( target, resp, opts ) {
            window.Misc.removeSpinner( this.el );
        }
   });

})(jQuery, this, this.document);
