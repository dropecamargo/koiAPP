/**
* Class DetalleCajaMenorView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.DetalleCajaMenorView = Backbone.View.extend({

        el: '#browse-detalle-cajamenor-list',
        events: {
            'click .item-detalle-cajamenor-remove': 'removeOne'
        },
        parameters: {
            reembolso: null,
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

            // References
            this.$valor = this.$('#total-valor');

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'store', this.storeOne );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'sync', this.responseServer);

            if( !_.isUndefined(this.parameters.dataFilter.cajamenor) && !_.isNull(this.parameters.dataFilter.cajamenor) ){
                this.confCollection.data.cajamenor = this.parameters.dataFilter.cajamenor;
                this.collection.fetch( this.confCollection );
            }
        },

        /**
        * Render view contact by model
        * @param Object cajamenor2Model Model instance
        */
        addOne: function (cajamenor2Model) {
            var view = new app.DetalleCajaMenorItemView({
                model: cajamenor2Model,
                parameters: {
                    edit: this.parameters.edit
                }
            });
            cajamenor2Model.view = view;
            this.$el.append( view.render().el );

            // Update total
            this.totalize();
        },

        /**
        * Render all view CajaMenorDetalle of the collection
        */
        addAll: function () {
            this.collection.forEach( this.addOne, this );
        },

        /**
        * stores detalleCajaMenor
        * @param form element
        */
        storeOne: function (data) {
            var _this = this

            // Set Spinner
            window.Misc.setSpinner( this.parameters.el );

            // Add model in collection
            var cajamenor2Model = new app.CajaMenor2Model();
            cajamenor2Model.save(data, {
                success : function(model, resp) {
                    if(!_.isUndefined(resp.success)) {
                        window.Misc.removeSpinner( _this.parameters.el );

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

                        // Clean form
                        _this.parameters.wrapperTemplate.html( _this.parameters.template({edit: _this.parameters.edit}) );
                        _this.ready();
                    }
                },
                error : function(model, error) {
                    window.Misc.removeSpinner( _this.parameters.el );
                    alertify.error(error.statusText)
                }
            });
        },

        /**
        * Event remove item
        */
        removeOne: function (e) {
            e.preventDefault();
            var _this = this;
                resource = $(e.currentTarget).attr("data-resource");
                model = this.collection.get(resource);
            if ( model instanceof Backbone.Model ) {
                model.destroy({
                    success : function(model, resp) {
                        if(!_.isUndefined(resp.success)) {
                            window.Misc.removeSpinner( _this.el );

                            if( !resp.success ) {
                                alertify.error(resp.errors);
                                return;
                            }

                            model.view.remove();
                            _this.collection.remove(model);

                            // Update total
                            _this.totalize();
                        }
                    }
                });
            }
        },

        /**
        * Render totalize valor
        */
        totalize: function () {
            var data = this.collection.total();
            this.$valor.html( window.Misc.currency(data) );

            // Render value in field cajamenor1_reembolso
            if (!_.isNull(this.parameters.reembolso))
                this.parameters.reembolso.val(data);
        },
        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();

            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();

            if( typeof window.initComponent.initInputMask == 'function' )
                window.initComponent.initInputMask();
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
