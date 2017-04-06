/**
* Class ItemRolloINListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ItemRolloINListView = Backbone.View.extend({

        tagName: 'tr',
        template: null,
        parameters: { 
            type: 'E'   
        },

        /**
        * Constructor Method
        */
        initialize: function( opts ) {
            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
        },

        /*
        * Render View Element
        */
        render: function(){
            this.template = _.template( ($( this.parameters.type == 'E' ? '#add-itemsrollos-tpl' : '#chooses-itemsrollos-tpl' ).html() || '') );

            var attributes = this.model.toJSON();
            this.$el.html( this.template(attributes) );
            return this;
        }
    });

})(jQuery, this, this.document);
