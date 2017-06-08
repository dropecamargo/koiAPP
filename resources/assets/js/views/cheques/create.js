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
            'submit #form-cheque2' : 'onStoreItem',
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

            // References fields          

            this.referenceView();
        },
        /**
        * Event submit devolucion1
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
                this.model.save( data, {patch: true, silent: true} );
            }   
        },  
        /**
        * Reference view collection
        */
        referenceView:function(){

        },

        /**
        *
        */
        onStoreItem: function(e){
            
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                // this.detalleAnticipoMedioPagoList.trigger( 'store', data );

                // Clean fields
                this.cleanFields();
            }
        },

        /**
        *  Clean fields del carros temporales
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
            // window.Misc.redirect( window.Misc.urlFull( Route.route('cheques.show', { cheques: resp.id})) );
            // window.Misc.redirect( window.Misc.urlFull( Route.route('cheques.index')));
        }
    });

})(jQuery, this, this.document);
