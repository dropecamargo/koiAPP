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

        events: {
            'click .submit-anticipo1' : 'submitForm',
            'submit #form-anticipo1' : 'onStore',
        },
        parameters: {
        },

        /**
        * Constructor Method
        */
        initialize : function() {
           
            // Attributes
            this.$wraperForm = this.$('#render-form-anticipo');

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
                this.model.save( data, {patch: true, silent: true} );
            }   
        },  
        /**
        * Reference view collection
        */
        referenceView:function(){
            e.preventDefault();
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
