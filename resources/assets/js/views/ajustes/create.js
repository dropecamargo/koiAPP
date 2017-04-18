/**
* Class CreateAjusteView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateAjusteView = Backbone.View.extend({

        el: '#ajuste-create',
        template: _.template(($('#add-ajuste-tpl').html() || '') ),
        templateDetailt: _.template(($('#add-detailt-ajuste-tpl').html() || '') ),
        events: {
            
            'click .submit-ajuste': 'submitFormAjuste', 
            'submit #form-ajustes' :'onStore',
            'submit #form-detalle-ajuste' :'onStoreItem',
            'change .change-in-or-exit-koi-component': 'changeTipoAjuste',
            'change .koi-changed-reclacification': 'changeReclacification'
        },
        parameters: {
        },

        /**
        * Constructor Method
        */
        initialize : function() {
           
            // Attributes
            this.$wraperForm = this.$('#render-form-ajuste');

            this.detalleAjuste = new app.AjustesDetalleCollection();
            
            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );            
        },


        /*
        * Render View Element
        */
        render: function() {
                        
            var attributes = this.model.toJSON();
            this.$wraperForm.html( this.template(attributes) );

            this.$form = this.$('#form-ajustes');
            this.$divDetalle = this.$('#detalle-ajuste');
            
             //Reference field select 
            this.$selectTipoAjuste = $('#ajuste1_tipoajuste');
            this.$fieldCantidadEntrada = $('#ajuste2_cantidad_entrada');
            this.$fieldCantidadSalida = $('#ajuste2_cantidad_salida');
            this.$fieldCosto = $('#ajuste2_costo');
            
            // Reference views
            this.referenceViews();
            
            this.ready();
        },


        referenceViews:function(){ 
            this.$formItem = this.$('#form-detalle-ajuste');
            this.detalleAjustesView = new app.DetalleAjustesView( {
                collection: this.detalleAjuste,
                parameters: {
                    wrapper: this.el,
                    edit: true,
                    dataFilter: {
                        'id': this.model.get('id')
                    }
               }
            });
        },
         /**
        * Event submit ajuste1
        */
        submitFormAjuste: function (e) {
            this.$form.submit();
        },
        /**
        * Event Create Ajuste
        */
        onStore: function (e) {
            
            if (!e.isDefaultPrevented()) {
                e.preventDefault();
                var data = window.Misc.formToJson( e.target );
                    data.ajuste2 = this.detalleAjuste.toJSON();
                this.model.save( data, {patch: true, silent: true} );

            }   
        },
        /**
        *Event store ajuste2 validate temporal carDetail
        */
        onStoreItem: function(e){

            if (!e.isDefaultPrevented()) {
                e.preventDefault();
                var data = window.Misc.formToJson( e.target );
                    data.tipoajuste = this.$selectTipoAjuste.val();
                    data.sucursal = this.$('#ajuste1_sucursal').val();
                window.Misc.evaluateActionsInventory({
                    'data': data,
                    'wrap': this.$el,
                    'callback': (function (_this) {
                        return function ( action , tipo)
                        {      
                            // Open InventarioActionView
                            if ( _this.inventarioActionView instanceof Backbone.View ){
                                _this.inventarioActionView.stopListening();
                                _this.inventarioActionView.undelegateEvents();
                            }

                            _this.inventarioActionView = new app.InventarioActionView({
                                model: _this.model,
                                collection: _this.detalleAjuste,
                                parameters: {
                                    data: data,
                                    action: action,
                                    tipo: tipo
                                }
                            });
                            _this.inventarioActionView.render();
                        }
                    })(this)
                });                
            }
        },
        
        /**
        *Event define tipoAjuste
        */
        changeTipoAjuste:function(e){
            var _this = this;
            tiposajuste = _this.$selectTipoAjuste.val();
            $.ajax({
                type: 'GET',
                url: window.Misc.urlFull(Route.route('tiposajuste.show',{tiposajuste: tiposajuste})),
                beforeSend: function() {
                    window.Misc.setSpinner( _this.el );
                }
            })
            .done(function(resp) {
                window.Misc.removeSpinner( _this.el );
                
                //Render form detalle ajuste
                _this.$divDetalle.empty().html( _this.templateDetailt(resp) );

                //Hide input lote
                (resp.tipoajuste_tipo == 'S') ? _this.$('#ajuste1_lotes').hide() : _this.$('#ajuste1_lotes').show(); 

                // Clear collection
                _this.detalleAjuste.reset();

                _this.ready();
            })       
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                window.Misc.removeSpinner( _this.el );
                alertify.error(thrownError);
            });
        },
        /**
        *change tipo reclacificacion
        */
        changeReclacification:function(e){
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                if ('#'+$(e.currentTarget).attr('id') == this.$fieldCantidadEntrada.selector) { 
                    $(this.$fieldCantidadSalida.selector).html(this.divDetalle).hide();
                }else{
                    $(this.$fieldCantidadEntrada.selector).html(this.divDetalle).hide();
                    $(this.$fieldCosto.selector).html(this.divDetalle).prop('readonly',true);
                    $('#ajuste2_producto').html(this.divDetalle).attr('data-costo', 'ajuste2_costo');              
                }
            }
        },
        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initICheck == 'function' )
                window.initComponent.initICheck(); 

            if( typeof window.initComponent.initInputMask == 'function' )
                window.initComponent.initInputMask();
            
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();
            
            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();
            
            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();

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
            // window.Misc.redirect( window.Misc.urlFull( Route.route('ajustes.show', { ajustes: resp.id})) );
        }
    });

})(jQuery, this, this.document);
