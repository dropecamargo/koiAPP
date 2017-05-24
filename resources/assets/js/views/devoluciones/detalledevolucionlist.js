/**
* Class DevolucionDetalle2View  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.DevolucionDetalle2View = Backbone.View.extend({

        el: '#browse-detalle-devolucion-list',
        events: {
            'change input.change-cant-devo' : 'cantidadDevolucion', 
            'click .all-devoluciones' : 'clickAll', 
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

            // reference input totales show
            this.$total = this.$('#total');
            this.$devueltas = this.$('#total_devueltas');
            this.$price = this.$('#total_price');
                    
            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'store', this.storeOne );
            this.listenTo( this.collection, 'sync', this.responseServer);

            if( !_.isUndefined(this.parameters.dataFilter.id) && !_.isNull(this.parameters.dataFilter.id) || !_.isUndefined(this.parameters.dataFilter.id_factura2) && !_.isNull(this.parameters.dataFilter.id_factura2) ){
                this.confCollection.data.id = this.parameters.dataFilter.id;
                this.confCollection.data.id_factura2 = this.parameters.dataFilter.id_factura2;
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
        * @param Object detalleDevolucionModel Model instance
        */
        addOne: function (detalleDevolucionModel) {
            var view = new app.DetalleDevolucionItemView({
                model: detalleDevolucionModel,
                parameters: {
                    edit: this.parameters.edit
                }
            });
            detalleDevolucionModel.view = view;
            this.$el.append( view.render().el );

            this.setModel(detalleDevolucionModel);
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
        *Evalua cantidad del input
        */
        cantidadDevolucion: function(e){
            e.preventDefault();
            this.$cantidad = this.$(e.currentTarget);
            var id = this.$cantidad.attr('id').split('_');
            var model = this.collection.get(id[2]);

            if (this.$cantidad.val() > model.get('factura2_cantidad') ) {
                return alertify.error('Cantidad no puede ser mayor a lo que se encuentra en la factura');
            }    

            model.set('devolucion2_cantidad', this.$cantidad.val());
            this.setModel(model);

            this.totalize();
        },
        /*
        *setea cantidad al modelo ya evaluada y render subtotal 
        */
        setModel:function(model){
            var subtotal = model.get('devolucion2_costo') -  model.get('devolucion2_descuento');
                iva = (subtotal * (model.get('devolucion2_iva') / 100));
                subtotal = subtotal + iva;
                subtotal = subtotal * model.get('devolucion2_cantidad');
            this.$('#total_'+model.get('id')).empty().html(window.Misc.currency(subtotal));
        },

        /**
        *Render totales the collection
        */
        totalize: function(){
            var data = this.collection.totalize();
            this.$devueltas.empty().html(data.devueltasTotal );
            this.$total.empty().html(window.Misc.currency(data.devolucion1_total) );
            this.$price.empty().html(window.Misc.currency(data.devolucion1_bruto) );
        },
        /*
        *Function devuelve todos los items
        */
        clickAll:function(e){
            e.preventDefault();
            this.collection.devolverTodo();
            this.addAll();
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
