/**
* Class ProductoActionView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ImportProductoActionView = Backbone.View.extend({

        el: 'body',
        template: _.template(($('#add-import-file-tpl').html() || '')),
        parameters: {
            action: {}
        },

        /**
        * Constructor Method
        */
        initialize : function( opts ) {
            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            this.$modal = $('#modal-import-file-component');
        },

        /*
        * Render View Element
        */
        render: function() {
            this.$modal.find('.modal-title').text( 'Importando ' + this.parameters.title );
            this.$modal.find('.content-modal').empty().html( this.template( this.parameters ) );
            this.$modal.modal('show');
            this.ready();
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

            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();
        },
    });

})(jQuery, this, this.document);
