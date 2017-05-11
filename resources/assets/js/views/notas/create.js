/**
* Class CreateNotaView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateNotaView = Backbone.View.extend({

        el: '#nota-create',
        template: _.template( ($('#add-nota-tpl').html() || '') ),
        events: {
            'click .submit-nota': 'submitNota',
            'submit #form-nota': 'onStore',
            'change .change-concepto': 'changeConcepto',
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
            this.$wraperForm = this.$('#render-form-nota');
            this.detalleNotaList = new app.DetalleNotaList();

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
            this.$form = this.$('#form-nota');

            this.referenceViews();
        },

        /**
        * Event submit nota
        */
        submitNota: function (e) {
            this.$form.submit();
        },

        /**
        * Event Create Folder
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {

                e.preventDefault();
                var data = window.Misc.formToJson( e.target );
                    data.nota2 = this.detalleNotaList.toJSON();
                this.model.save( data, {patch: true, silent: true} );
            }
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            //DetalleNotaList
            this.detalleNotasView = new app.DetalleNotasView( {
                collection: this.detalleNotaList,
                parameters: {
                    wrapper: this.$('#wrapper-detalle'),
                    edit: true,
                    dataFilter: {
                        'nota2': this.model.get('id')
                    }
               }
            });
        },

        changeConcepto: function(e){
            this.$el.find('tbody').html('');
            this.detalleNotaList.reset();

            var data = window.Misc.formToJson( e.target );
                data.tercero = this.$('#nota1_conceptonota').attr('data-tercero');
                data.call = 'nota';

            if( !_.isUndefined(data.nota1_conceptonota) && !_.isNull(data.nota1_conceptonota) && data.nota1_conceptonota != ''){
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
                                collection: _this.detalleNotaList,
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
            if( typeof window.initComponent.initICheck == 'function' )
                window.initComponent.initICheck();

            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();
            
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();

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

                window.Misc.redirect( window.Misc.urlFull( Route.route('notas.index')) );
            }
        }
    });

})(jQuery, this, this.document);
