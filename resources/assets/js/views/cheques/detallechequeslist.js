/**
* Class DetalleChequesView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.DetalleChequesView = Backbone.View.extend({

        el: '#browse-cheque-list',
        events: {
            'click .item-cheque-remove': 'removeOne'
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

            this.parameters.wrapper

            //Init Attributes
            this.confCollection = { reset: true, data: {} };

            // References
            this.$valor = this.$('#total');

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'store', this.storeOne );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'sync', this.responseServer);
            
            if( !_.isUndefined(this.parameters.dataFilter.chposfechado2) && !_.isNull(this.parameters.dataFilter.chposfechado2) ){
                this.confCollection.data.chposfechado2 = this.parameters.dataFilter.chposfechado2;
                this.collection.fetch( this.confCollection );
            }
        },

        /**
        * Render view contact by model
        * @param Object detalleReciboModel Model instance
        */
        addOne: function (chposfechado2) {
            var view = new app.DetalleChequeItemView({
                model: chposfechado2,
                parameters: {
                    edit: this.parameters.edit
                }
            });
            chposfechado2.view = view;
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
        * stores cheque
        * @param form element
        */
        storeOne: function ( data ) {    
            var _this = this;

            if( !_.isUndefined(data.factura3_id) ){
                var valid = this.collection.validar(data);
                if(!valid.success){
                    this.totalize();
                    return;
                }
            }
            // Set Spinner
            window.Misc.setSpinner( this.parameters.wrapper );

            // Add model in collection
            var chposfechado2 = new app.ChposFechado2Model();
            chposfechado2.save(data, {
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
                
                // Update total
                this.totalize();
            }
        },

        /**
        * Render totalize valor
        */
        totalize: function () {
            var data = this.collection.totalize();

            if(this.$valor.length) {
                this.$valor.html( window.Misc.currency(data.valor) );
            }
            $('#chposfechado1_valor').val(data.valor);
            $('#chposfechado2_conceptosrc').val('').trigger('change.select2');
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( model, xhr, opts ) {
            window.Misc.setSpinner( this.parameters.wrapper );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            window.Misc.removeSpinner( this.parameters.wrapper );
        }
   });
})(jQuery, this, this.document);
