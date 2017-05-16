/**
* Class ProdbodeListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ProdbodeListView = Backbone.View.extend({

        el: '#render-series',
        events: {
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

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'sync', this.responseServer);

            this.collection.fetch({ data: {producto_id: this.parameters.dataFilter.producto_id, sucursal: this.parameters.dataFilter.sucursal}, reset: true });

        },

        /*
        * Render View Element
        */
        render: function() {
        },
ready:function(){

            if( typeof window.initComponent.initICheck == 'function' )
                window.initComponent.initICheck();
},
        /**
        * Render view contact by model
        * @param Object prodbodeModel Model instance
        */
        addOne: function (prodbodeModel) {
            var view = new app.ProdbodeItemView({
                model: prodbodeModel,
                parameters: {
                    edit: this.parameters.edit
                }
            });
            prodbodeModel.view = view;
            this.$el.prepend( view.render().el );
                        this.ready();
        },

        /**
        * Render all view Marketplace of the collection
        */
        addAll: function () {
            this.collection.forEach( this.addOne, this );
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
