/**
* Class AnticipoItemView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.AnticipoItemView = Backbone.View.extend({
        
        tagName: 'tr',
        template: _.template( ($('#choose-anticipo-item-tpl').html() || '') ),
        parameters: {
        },

        /**
        * Constructor Method
        */
        initialize: function(opts){
            // Extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
        },

        /*
        * Render View Element
        */
        render: function(){
            var attributes = this.model.toJSON();
                attributes.call = this.parameters.call;
            this.$el.html( this.template(attributes) );
            return this;
        }
    });
})(jQuery, this, this.document);