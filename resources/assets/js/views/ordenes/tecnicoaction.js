/**
* Class TecnicoActionView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.TecnicoActionView = Backbone.View.extend({

        el: '#orden-content-section',
        templateRemision: _.template(($('#add-remision-tpl').html() || '')),
        templateFactura: _.template(($('#add-factura-tecnico-tpl').html() || '')),
        events: {
            'click .click-store-remsion': 'onStoreRemision',
            'click .click-add-item': 'submitForm',
            'submit #form-remrepu': 'onStoreItem',

            'click .click-store-factura': 'submitFormFactura',
            'submit #form-factura-tecnico': 'submitCloseOrden',
        },
        parameters: {
            data: {},
            action: {}
        },

        /**
        * Constructor Method
        */
        initialize : function( opts ) {
            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            // Prepare collection
            this.remrepu = new app.RemRepuCollection();

            this.$modalCreate =  this.$('#modal-create-remision');
            this.$modalFactura =  this.$('#modal-create-factura');
            this.$form =  this.$('#form-remrepu');
            this.$formFactura =  this.$('#form-factura-tecnico');

            this.listenTo( this.collection, 'sync', this.responseServer );
        },

        /*
        * Render View Element
        */
        render: function() {
           var resp = this.parameters,
           _this = this,
            stuffToDo = {
                'remision': function() {
                    _this.$modalCreate.modal('show');
                    var data = {sucursal: resp.data.remrempu1_sucursal};
                    _this.$modalCreate.find('.content-modal').empty().html( _this.templateRemision( data ) );
                    _this.el = _this.$('#browse-legalizacions-list');

                    _this.referenceView();
                },
                'factura': function() {
                    _this.$modalFactura.modal('show');
                    _this.$modalFactura.find('.content-modal').empty().html( _this.templateFactura(_this.model.toJSON() ) );
                    _this.ready();
                }
            };
            if (stuffToDo[resp.action]) {
                stuffToDo[resp.action]();
            }
		},

        /**
        * Collection remrepu View
        */
        referenceView: function(){
            this.remRepuView = new app.RemRepuView( {
                collection: this.remrepu,
                el: this.el,
                parameters: {
                    edit: true,
                    call: 'store',
                    dataFilter: {
                        'remrepu2_remrepu1': 'remrepu2_remrepu1',
                    }
                }
            });
        },

        /**
        * Sumbit form
        */
        submitForm: function(e){
            this.$form.submit();
        },
        /**
        * Sumbit form
        */
        submitFormFactura: function(e){
            this.$formFactura.submit();
        },

        /**
        * On store in collection
        */
        onStoreItem: function(e){
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                    data.sucursal = this.$('#remrepu2_serie').attr('data-sucursal');
                this.remrepu.trigger( 'store', data );
            }
        },

        /**
        * Store Remision (RemRepu1)
        */
        onStoreRemision: function(e){
            e.preventDefault();

            // Prepare data
            var data = [];
                data.detalle = this.remrepu.toJSON();
                data.remrepu_orden = this.model.get('id');
                data.tecnico = this.parameters.data.remrempu1_tecnico;
                data.sucursal = this.parameters.data.remrempu1_sucursal;

            this.collection.trigger( 'store', data );
        },

        /**
        *  Close orden and submit factura
        */
        submitCloseOrden: function(e){
            e.preventDefault();
            var _this = this;
            var data = window.Misc.formToJson( e.target );
                data.tercero = _this.model.get('tercero_nit');
                data.id_orden = _this.model.get('id');
                data.factura2 = _this.parameters.data;
            // Cerrar orden
            $.ajax({
                url: window.Misc.urlFull( Route.route('ordenes.cerrar') ),
                type: 'POST',
                data : data,
                beforeSend: function() {
                    window.Misc.setSpinner( _this.spinner );
                }
            })
            .done(function(resp) {
                window.Misc.removeSpinner( _this.spinner );

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

                    window.Misc.successRedirect( resp.msg, window.Misc.urlFull(Route.route('ordenes.show', { ordenes: _this.model.get('id') })) );
                }
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                window.Misc.removeSpinner( _this.spinner );
                alertify.error(thrownError);
            });
        },

    	/**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();

            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();

            if( typeof window.initComponent.initDatePicker == 'function' )
                window.initComponent.initDatePicker();

            if( typeof window.initComponent.initInputMask == 'function' )
                window.initComponent.initInputMask();

            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();
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

                this.parameters.remrepu2.fetch({ data: {orden_id: this.parameters.data.orden_id}, reset: true });
                this.$modalCreate.modal('hide');
            }
        }
    });

})(jQuery, this, this.document);
