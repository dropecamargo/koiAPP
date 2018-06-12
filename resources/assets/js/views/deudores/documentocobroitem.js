/**
* Class DocumentoCobroItemView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.DocumentoCobroItemView = Backbone.View.extend({

        tagName: 'tr',
        template: _.template( ($('#add-documentocobro-item-tpl').html() || '') ),

        /**
        * Constructor Method
        */
        initialize: function(){
            // Events Listener
            this.listenTo( this.model, 'change', this.render );
        },

        /*
        * Render View Element
        */
        render: function(){
            var attributes = this.model.toJSON();
            if( attributes.days <= 0 && attributes.days >= -30 ){
                this.$el.addClass('bg-menor30');
            }else if ( attributes.days <= -31 && attributes.days >= -60 ){
                this.$el.addClass('bg-menor60');
            }else if ( attributes.days <= -61 && attributes.days >= -90 ){
                this.$el.addClass('bg-menor90');
            }else if ( attributes.days <= -91 && attributes.days >= -180 ){
                this.$el.addClass('bg-menor180');
            }else if ( attributes.days <=   -181 && attributes.days >= -360 ){
                this.$el.addClass('bg-menor360');
            }else if ( attributes.days < -360 ){
                this.$el.addClass('bg-mayor360');
            }
            this.$el.html( this.template(attributes) );
            return this;
        }
    });

})(jQuery, this, this.document);
