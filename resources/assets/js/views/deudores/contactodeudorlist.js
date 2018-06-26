/**
* Class ContactoDeudorView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ContactoDeudorView = Backbone.View.extend({

        el: '#browse-contactos-deudor-list',
        events: {
            'click .btn-edit-contactodeudor': 'editOne'
        },
        parameters: {
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
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'store', this.storeOne );
            this.listenTo( this.collection, 'sync', this.responseServer);

            // Trigger
            this.on('createOne', this.createOne, this);
            this.collection.fetch({ data: {deudor_id: this.parameters.dataFilter.deudor_id}, reset: true });
        },

        /*
        * Render View Element
        */
        render: function() {

        },

        /**
        * Render view contact by model
        * @param Object contactodeudorModel Model instance
        */
        addOne: function (contactodeudorModel) {
            var view = new app.ContactoDeudorItemView({
                model: contactodeudorModel
            });
            contactodeudorModel.view = view;
            this.$el.append( view.render().el );
        },

        /**
        * Render all view Marketplace of the collection
        */
        addAll: function () {
            this.$el.find('tbody').html('');
            this.collection.forEach( this.addOne, this );
        },

        editOne: function(e) {
            e.preventDefault();

            var resource = $(e.currentTarget).attr("data-resource"),
                model = this.collection.get(resource),
                _this = this;

            if ( this.createContactoDeudorView instanceof Backbone.View ){
                this.createContactoDeudorView.stopListening();
                this.createContactoDeudorView.undelegateEvents();
            }

            this.createContactoDeudorView = new app.CreateContactoDeudorView({
                model: model
            });
            this.createContactoDeudorView.render();
        },

        createOne: function(deudor) {
            var _this = this;
            if ( this.createContactoDeudorView instanceof Backbone.View ){
                this.createContactoDeudorView.stopListening();
                this.createContactoDeudorView.undelegateEvents();
            }

            this.createContactoDeudorView = new app.CreateContactoDeudorView({
                model: new app.ContactoDeudorModel(),
                collection: _this.collection,
                parameters: {
                    'deudor_id': deudor
               }
            });
            this.createContactoDeudorView.render();
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
