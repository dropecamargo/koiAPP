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
        events: {
            'click .click-store-remsion': 'onStoreRemision',
            'click .click-add-item': 'submitForm',
            'submit #form-remrepu': 'onStoreItem',
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
            this.$form =  this.$('#form-remrepu');

            this.listenTo( this.collection, 'sync', this.responseServer );
        },

        /*
        * Render View Element
        */
        render: function() {
            var data = {sucursal: this.parameters.data.remrempu1_sucursal}
            this.$modalCreate.find('.content-modal').empty().html( this.templateRemision( data ) );
            this.el = this.$('#browse-legalizacions-list');

            this.referenceView();
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
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();

            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();
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
