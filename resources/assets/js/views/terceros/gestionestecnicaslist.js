/**
* Class GestionTecnicaListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.GestionTecnicaListView = Backbone.View.extend({

        el: '#browse-gestiontecnica-list',
        events: {
        },
        parameters: {
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

            this.collection.fetch({ data: { tercero: this.parameters.dataFilter.tercero }, reset: true });
            
        },

        /*
        * Render View Element
        */
        render: function() {

        },

        /**
        * Render view contact by model
        * @param Object gestionTecnicaModel Model instance
        */
        addOne: function (gestionTecnicaModel) {
            
            var view = new app.GestionTecnicaItemView({
                model: gestionTecnicaModel,
                parameters: {
                    edit: this.parameters.edit
                }
            });
            gestionTecnicaModel.view = view;
            this.$el.prepend( view.render().el );
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
