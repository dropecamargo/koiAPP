/**
* Class VisitasView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.VisitasView = Backbone.View.extend({

        el: '#browse-visitas-list',
        events: {
               'click .item-visita-remove': 'removeOne'
        },
        parameters: {
            wrapper:false,
            edit:false,
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
            this.listenTo( this.collection, 'store', this.storeOne );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'sync', this.responseServer);

            this.collection.fetch({ data: {orden_id: this.parameters.dataFilter.orden_id}, reset: true });
           
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
        addOne: function (visitaModel) {
            var model = this.collection.at(this.collection.length -1);
            var view = new app.VisitasItemView({
                model: visitaModel,
                parameters: {
                    edit: this.parameters.edit,
                    last: model.get('id')
                }
            });
            visitaModel.view = view;
            this.$el.prepend( view.render().el );
        },

        /**
        * Render all view Marketplace of the collection
        */
        addAll: function () {
            this.collection.forEach( this.addOne, this );
        },

        storeOne: function (data) {
            var _this = this;

            // Set Spinner
            window.Misc.setSpinner( this.parameters.wrapper );

            // Prepare data
            data.visita_orden = this.parameters.dataFilter.orden_id;

            // Add model in collection
            var visitaModel = new app.VisitaModel();
            visitaModel.save(data, {
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

                        var model = _this.collection.at(_this.collection.length -2);
                        _this.$wrappertd = _this.$el.find("#td_"+model.get('id'));
                        _this.$wrappertd.find('a').remove();
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

            var resource = $(e.currentTarget).attr("data-resource"),
                model = this.collection.get(resource),
                _this = this;

            if ( model instanceof Backbone.Model ) {
                model.destroy({
                    success : function(model, resp) {
                        if(!_.isUndefined(resp.success)) {
                            window.Misc.removeSpinner( _this.parameters.wrapper );
                            if( !resp.success ) {
                                alertify.error(resp.errors);
                                return;
                            }
                            model.view.remove();
                            var model = _this.collection.at(_this.collection.length -1);
                            _this.$wrappertd = _this.$el.find("#td_"+model.get('id'));
                            _this.$wrappertd.html("<a class='btn btn-default btn-xs item-visita-remove' data-resource='"+ model.get('id')+"'><span><i class='fa fa-times'></i></span></a>");
                        }
                    }
                });
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

                window.Misc.clearForm( $('#form-visitas') );
            }
        }
   });

})(jQuery, this, this.document);
