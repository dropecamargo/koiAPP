/**
* Class CommentFacturaView  of Backbone
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CommentFacturaView = Backbone.View.extend({

      	el: '#modal-comments-factura',
        template: _.template( ($('#comments-tpl').html() || '') ),
		events: {
            'submit #form-comment-factura' : 'onStore',
            'click .item-comment-remove': 'removeOne',
            'click .btn-add-collection' : 'addCollectionModel',
		},

        /**
        * Constructor Method
        */
		initialize: function(opts) {
            // Extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            // Reference Collection Factura4
            this.reset = false;
            if (this.model.has('comments')) {
                this.commentInList = this.model.get('comments');
                this.reset = true;
            }else{
                this.commentInList = new app.CommentInList();
            }
            // Events Listeners
            this.listenTo( this.commentInList, 'add', this.addOne );
            this.listenTo( this.commentInList, 'reset', this.addAll );
            this.listenTo( this.commentInList, 'store', this.storeOne );
            this.listenTo( this.commentInList, 'request', this.loadSpinner);
            this.listenTo( this.commentInList, 'sync', this.responseServer);
		},

        /**
        * Render view element
        */
        render: function (){

            // Extend attributes modal
            this.$el.find('.content-modal').html( this.template(this.model) );
            this.$form = this.$('#form-comment-factura');
            this.$wraper = this.$('#browse-comment-factura-list');

            // Open modal
            this.$el.modal('show');
            this.ready();

            if (this.reset) {
                this.commentInList.trigger('reset');
            }
        },
        /**
        * Store one element comment
        * @param form element
        */
        storeOne: function ( data ) {
            var _this = this;

            // Set Spinner
            window.Misc.setSpinner( this.$el);

            // Add model in collection
            var factura4Model = new app.Factura4Model();
            factura4Model.save(data, {
                success : function(model, resp) {
                    if(!_.isUndefined(resp.success)) {

                        window.Misc.removeSpinner( _this.parameters.wrapper );
                        var text = resp.success ? '' : resp.errors;
                        if( _.isObject( resp.errors ) ) {
                            text = window.Misc.parseErrors(resp.errors);
                        }

                        if( !resp.success ) {
                            alertify.error(text);
                            return;
                        }

                        // Add model in collection
                        _this.commentInList.add(model);
                    }
                },
                error : function(model, error) {
                    window.Misc.removeSpinner( _this.parameters.wrapper );
                    alertify.error(error.statusText)
                }
            });
        },
        /**
        * Render view task by model
        * @param Object CommentModel Model instance
        */
        addOne: function (commentModel) {
            var view = new app.ItemCommentInListView({
                model: commentModel
            });
            commentModel.view = view;
            this.$wraper.append( view.render().el );
        },
        /**
        * Render all view of the collection
        */
        addAll: function () {
            this.commentInList.forEach( this.addOne, this );
        },
        /*
        * Event onStore commnet in Model the factura2
        */
        onStore: function(e){
            if (!e.isDefaultPrevented()) {
                e.preventDefault();
                var data = window.Misc.formToJson( e.target );
                this.commentInList.trigger( 'store', data );
            }
        },

        /**
        * Event remove item
        */
        removeOne: function (e) {
            e.preventDefault();
            var resource = $(e.currentTarget).attr("data-resource");
                model = this.commentInList.get(resource);

            if ( model instanceof Backbone.Model ) {
                model.view.remove();
                this.commentInList.remove(model);
            }
        },

        /**
        * Event add collection model
        */
        addCollectionModel: function(e){
            e.preventDefault();
            this.model.set('comments', this.commentInList);

            // Close modal
            this.$el.modal('hide');
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();

            if( typeof window.initComponent.initSpinner == 'function' )
                window.initComponent.initSpinner();
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( model, xhr, opts ) {
            window.Misc.setSpinner( this.$el );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            window.Misc.removeSpinner( this.$el );
            window.Misc.clearForm( this.$form );
        }
    });
})(jQuery, this, this.document);
