/**
* Class RemRepuView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.RemRepuView = Backbone.View.extend({

        el: null,
        events: {
           'click .item-remrepu-remove': 'removeOne'
        },
        parameters: {
            wrapper: false,
            edit: false,
            call: null,
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
            this.listenTo( this.collection, 'store', this.storeOne );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'sync', this.responseServer);

            this.el = this.parameters.el;

            if( !_.isUndefined(this.parameters.dataFilter) && !_.isNull(this.parameters.dataFilter) ){
                this.confCollection.data = this.parameters.dataFilter;
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
        * @param Object contactModel Model instance
        */
        addOne: function (remRepu2Model) {
            var view = new app.RemRepuItemView({
                model: remRepu2Model,
                parameters: {
                    edit: this.parameters.edit,
                    call: this.parameters.call
                }
            });

            remRepu2Model.view = view;
            this.$el.prepend( view.render().el );
        },

        /**
        * Render all view Marketplace of the collection
        */
        addAll: function () {
            this.$el.find('tbody').html('');
            this.collection.forEach( this.addOne, this );
        },

        storeOne: function (data) {
            var _this = this;

            // var legalizacion = this.collection.storeLegalizacion( data, this.parameters.wrapper );
            // if(!legalizacion.success){
            //     return;
            // }

            // Set Spinner
            window.Misc.setSpinner( this.parameters.wrapper );

            // Prepare data
            data.orden_id = this.parameters.dataFilter.orden_id;

            // Add model in collection
            var remRepu2Model = new app.RemRepu2Model();
            remRepu2Model.save(data, {
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
        * Event remove item
        */
        removeOne: function (e) {
            e.preventDefault();

            var resource = $(e.currentTarget).attr("data-resource");
            var model = this.collection.get(resource);

            if ( model instanceof Backbone.Model ) {
                model.view.remove();
                this.collection.remove(model);
            }
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {
            window.Misc.setSpinner( this.parameters.wrapper );
        },

        /**
        * response of the server
        */
        responseServer: function ( target, resp, opts ) {
            window.Misc.removeSpinner( this.parameters.wrapper );
            
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

                window.Misc.clearForm( $('#form-remrepu') );
            }
        }
   });

})(jQuery, this, this.document);
