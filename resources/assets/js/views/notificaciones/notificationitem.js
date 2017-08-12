/**
* Class NotificationItemView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.NotificationItemView = Backbone.View.extend({

        tagName: 'li',
        className: 'item view-notification',
        template: _.template( ($('#add-notification-tpl').html() || '') ),
        parameters: {
            call: null,
        },

        /**
        * Constructor Method
        */
        initialize: function(opts) {
            // Initialize
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
        },

        /*
        * Render View Element
        */
        render: function(){
            if( this.parameters.call != 'A'){
                var attributes = this.model.toJSON();
            }else{
                var attributes = this.model;
            }

            if( !parseInt(attributes.notificacion_visto) ){
                this.$el.addClass('visto-notification');
            }
            this.$el.attr('data-notification', attributes.id );
            this.$el.html( this.template(attributes) );
            return this;
        }
    });

})(jQuery, this, this.document);
