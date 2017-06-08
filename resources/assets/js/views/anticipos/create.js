/**
* Class CreateAnticipoView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateAnticipoView = Backbone.View.extend({

        el: '#anticipo-create',
        template: _.template(($('#add-anticipos-tpl').html() || '') ),
        templateDetalleAnticipo2: _.template(($('#add-anticipomedio-tpl').html() || '') ),

        events: {
            'click .submit-anticipo1' : 'submitForm',
            'submit #form-anticipo1' : 'onStore',
            'submit #form-anticipo2' : 'onStoreItem2',
            'submit #form-anticipo3' : 'onStoreItem3',
            'change .change-medio-pago' : 'changeMedio',
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
            this.$wraperForm = this.$('#render-form-anticipo');

            this.detalleAnticipoMedioPagoList = new app.DetalleAnticipo2List();
            this.detalleAnticipoConceptoList = new app.DetalleAnticipo3List();

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

            this.$form = this.$('#form-anticipo1');

            // References fields          
            this.$concepto = this.$('#anticipo3_conceptosrc');
            this.$naturaleza = this.$('#anticipo3_naturaleza');
            this.$valorConcepto = this.$('#anticipo3_valor'); 
            this.$medio = this.$('#anticipo2_mediopago');

            this.referenceView();
        },
        /**
        * Event submit devolucion1
        */
        submitForm: function (e) {
            this.$form.submit();
        },

        /**
        * Event Create anticipos
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                    data.anticipo2 = this.detalleAnticipoMedioPagoList.toJSON();
                    data.anticipo3 = this.detalleAnticipoConceptoList.toJSON();
                this.model.save( data, {patch: true, silent: true} );
            }   
        },  
        /**
        * Reference view collection
        */
        referenceView:function(){

            // detalleAnticipoMedioPagoList
            this.detalleAnticiposMediosView = new app.DetalleAnticiposMediosView({
                collection: this.detalleAnticipoMedioPagoList,
                parameters: {
                    edit: true,
                    dataFilter: {
                        'anticipo2': this.model.get('id')
                    }
                }
            });
            
            //detalleAnticipoConceptoList
            this.detalleAnticiposView = new app.DetalleAnticiposView( {
                collection: this.detalleAnticipoConceptoList,
                parameters: {
                    edit: true,
                    dataFilter: {
                        'anticipo3': this.model.get('id')
                    }
               }
            });
        },

        /**
        * Event change medio de pago 
        */
        changeMedio: function(e){
            e.preventDefault();
            // References
            this.$detailMedio = this.$('#detail-medio-pago');
            var _this = this;
                medio = _this.$(e.currentTarget).val();
                attributes = this.model.toJSON();
            $.ajax({
                type: 'GET',
                url: window.Misc.urlFull(Route.route('mediopagos.show',{ mediopagos: medio })),
                beforeSend: function() {
                    window.Misc.setSpinner( _this.el );
                }
            })
            .done(function(resp) {

                window.Misc.removeSpinner( _this.el );
                
                attributes.resp = resp;

                //Render form detalle medioPago
                _this.$detailMedio.empty().html( _this.templateDetalleAnticipo2( attributes, resp ) );
                _this.$banco = _this.$('#anticipo2_banco_medio');
                _this.$numeroMedio = _this.$('#anticipo2_numero_medio');
                _this.$fecha = _this.$('#anticipo2_vence_medio');
                _this.$valorMedio = _this.$('#anticipo2_valor');

                _this.ready();
            })       
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                window.Misc.removeSpinner( _this.el );
                alertify.error(thrownError);
            });
        },
        /**
        *
        */
        onStoreItem2: function(e){
            
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                this.detalleAnticipoMedioPagoList.trigger( 'store', data );

                // Clean fields
                this.cleanFields();
            }
        },
        /**
        *
        */
        onStoreItem3: function(e){

            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                if (this.detalleAnticipoMedioPagoList.length == 0) {
                    this.cleanFields();
                    return alertify.error('Por favor ingresar medio de pago antes de agregar concepto detalle del anticipo');
                }

                var data = window.Misc.formToJson( e.target );
                this.detalleAnticipoConceptoList.trigger( 'store', data );

                // Clean fields
                this.cleanFields();
            }
        },

        /**
        *
        */
        cleanFields: function(){

            this.$concepto.val('').trigger('change.select2');
            this.$naturaleza.val('');
            this.$valorConcepto.val('');

            if (this.detalleAnticipoMedioPagoList.length > 0) {
                this.$banco.val('').trigger('change.select2');
                this.$numeroMedio.val('');
                this.$fecha.val(moment().format('YYYY-MM-DD'));
                this.$medio.val('').trigger('change.select2');
                this.$valorMedio.val('');
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
            // window.Misc.redirect( window.Misc.urlFull( Route.route('anticipos.show', { anticipos: resp.id})) );
            window.Misc.redirect( window.Misc.urlFull( Route.route('anticipos.index')));
        }
    });

})(jQuery, this, this.document);
