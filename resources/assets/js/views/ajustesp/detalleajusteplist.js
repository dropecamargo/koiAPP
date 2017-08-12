/**
* Class DetalleAjustepView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.DetalleAjustepView = Backbone.View.extend({

        el: '#browse-detalle-ajustep-list',
        events: {
            'click .item-detalleajustep-remove': 'removeOne'
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

            // References
            this.$debito = this.$('#total-debito');
            this.$credito = this.$('#total-credito');

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'store', this.storeOne );
            this.listenTo( this.collection, 'sync', this.responseServer);
            
            if( !_.isUndefined(this.parameters.dataFilter.ajustep) && !_.isNull(this.parameters.dataFilter.ajustep) ){
                this.confCollection.data.ajustep = this.parameters.dataFilter.ajustep;
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
        * @param Object ajustep2Model Model instance
        */
        addOne: function (ajustep2Model) {
            var view = new app.DetalleAjustepItemView({
                model: ajustep2Model,
                parameters: {
                    edit: this.parameters.edit
                }
            });
            ajustep2Model.view = view;
            this.$el.append( view.render().el );

            // Update total
            this.totalize();
        },

        /**
        * Render all view Marketplace of the collection
        */
        addAll: function () {
            this.collection.forEach( this.addOne, this );
        },

        /**
        * stores detalleAjustec
        * @param form element
        */
        storeOne: function (data) {  
            var _this = this
            if( !_.isUndefined(data.facturap3_id)){
                var valid = this.collection.validar(data);
                if(!valid.success){
                    this.totalize();
                    return;
                }
            }
            // Set Spinner
            window.Misc.setSpinner( this.parameters.wrapper );
            
            // Add model in collection
            var ajustep2Model = new app.Ajustep2Model();
            ajustep2Model.save(data, {
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
        * Render totalize valor
        */
        totalize: function () {
            var data = this.collection.totalize();
            if(this.$debito.length) {
                this.$debito.html( window.Misc.currency(data.debito) );
            }

            if(this.$credito.length) {
                this.$credito.html( window.Misc.currency(data.credito) );
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
