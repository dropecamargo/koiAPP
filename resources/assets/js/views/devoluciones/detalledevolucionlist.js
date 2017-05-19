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
            'click .item-detalledevolucion-remove': 'removeOne',
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
        },
        /**
        * stores detalleDevolucion
        * @param form element
        */
        storeOne: function (data) {      
            var _this = this;
                
            // Set Spinner
            window.Misc.setSpinner( this.parameters.wrapper );

        },
        /**
        * Render all view Marketplace of the collection
        */
        addAll: function () {
            this.$el.find('tbody').html('');
            this.collection.forEach( this.addOne, this );
        },

        /**
        * Event remove item
        */
        removeOne: function (e) {
            e.preventDefault();
            console.log(e); 
            var resource = $(e.currentTarget).attr("data-resource");
                model = this.collection.get(resource);

            if ( model instanceof Backbone.Model ) {
                model.view.remove();
                this.collection.remove(model);
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
