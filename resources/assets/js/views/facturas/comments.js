/**
* Class CommentFacturaView  of Backbone
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CommentFacturaView = Backbone.View.extend({

      	el: '#modal-comments-factura',
        template: _.template( ($('#add-comments-tpl').html() || '') ),
		events: {
            'submit #form-comment-factura' : 'onStore',
		},

        /**
        * Constructor Method
        */
		initialize: function(opts) {
            // Extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);
		},

        /**
        * Render view element
        */
        render: function (){
            // Extend attributes confirm window
            this.$el.find('.content-modal').html( this.template(this.model) );
            this.$el.modal('show');
            this.$form = this.$('#form-comment-factura');
        },
        /*
        * Event set factura2_detalle
        */
        onStore: function(e){
            if (!e.isDefaultPrevented()) {
                e.preventDefault();
                
                var data = window.Misc.formToJson( e.target );
                this.model.set('factura2_detalle', data.factura2_detalle);

                this.$el.modal('hide');
            }
        },
    });
})(jQuery, this, this.document);
