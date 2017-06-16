/**
* Class CreateChequesView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateChequesView = Backbone.View.extend({

        el: '#cheque-create',
        template: _.template(($('#add-cheques-tpl').html() || '') ),

        events: {
            'click .submit-cheque1' : 'submitForm',
            'submit #form-cheque1' : 'onStore',
            'change .change-concepto' : 'changeConcepto',
        },
        parameters: {
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {

            // Initialize
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);
           
            // Attributes
            this.$wraperForm = this.$('#render-form-cheque');

            this.detalleChposFechado = new app.DetalleChposFechadoList();

            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );            
            
            this.ready(); 
        },

        /*
        * Render View Element
        */
        render: function() {
            
            var attributes = this.model.toJSON();
            this.$wraperForm.html( this.template(attributes) );

            this.$form = this.$('#form-cheque1');

            this.referenceView();
        },
        /**
        * Event submit cheque
        */
        submitForm: function (e) {
            this.$form.submit();
        },

        /**
        * Event Create cheques
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                    data.detalle = this.detalleChposFechado.toJSON();
                this.model.save( data, {patch: true, silent: true} );
            }   
        },  
        /**
        * Reference view collection
        */
        referenceView:function(){

          //DetalleChequesList
            this.detalleChequesView = new app.DetalleChequesView( {
                collection: this.detalleChposFechado,
                parameters: {
                    wrapper: this.$('#detail-chposfechado'),
                    edit: true,
                    dataFilter: {
                        'chposfechado2': this.model.get('id')
                    }
               }
            });
        },

        changeConcepto:function(e){
            var data = window.Misc.formToJson( e.target );
                data.tercero = this.$(e.currentTarget).attr('data-tercero');
                data.call = 'chposfechado';

            if( !_.isUndefined(data.chposfechado2_conceptosrc) && !_.isNull(data.chposfechado2_conceptosrc) && data.chposfechado2_conceptosrc != ''){
                window.Misc.evaluateActionsCartera({
                    'data': data,
                    'wrap': this.$el,
                    'callback': (function (_this) {
                        return function ( action )
                        {      
                            // Open CarteraActionView
                            if ( _this.carteraActionView instanceof Backbone.View ){
                                _this.carteraActionView.stopListening();
                                _this.carteraActionView.undelegateEvents();
                            }

                            _this.carteraActionView = new app.CarteraActionView({
                                model: _this.model,
                                collection: _this.detalleChposFechado,
                                parameters: {
                                    data: data,
                                    action: action,
                                }
                            });
                            _this.carteraActionView.render();
                        }
                    })(this)
                });
            }
        },
        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();
            
            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();
            
            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();

            if( typeof window.initComponent.initInputMask == 'function' )
                window.initComponent.initInputMask();

            if( typeof window.initComponent.initDatePicker == 'function' )
                window.initComponent.initDatePicker();
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (model, xhr, opts) {
            window.Misc.setSpinner( this.el );
            
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            window.Misc.removeSpinner( this.el );

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
            }
            window.Misc.redirect( window.Misc.urlFull( Route.route('cheques.show', { cheques: resp.id})) );
        }
    });

})(jQuery, this, this.document);
