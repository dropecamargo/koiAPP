/**
* Class Facturap3ItemView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.Facturap3ItemView = Backbone.View.extend({

        tagName: 'tr',
        parameters: {
            edit: false,
        },

        /**
        * Constructor Method
        */
        initialize: function(opts){
	        // Extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);
            if(this.parameters.call == 'ajustep'){
                this.template = _.template( ($('#add-item-ajustep-tpl').html() || '') );
            }
            // Events Listener
            this.listenTo( this.model, 'change', this.render );
        },

        /*
        * Render View Element
        */
        render: function(){
            var attributes = this.model.toJSON();
            attributes.edit = this.parameters.edit;
            attributes.call = this.parameters.call;

            if( attributes.call == 'tercero' ){
                this.$el.html( this.parameters.template(attributes) );
            }else{
                this.$el.html( this.template(attributes) );
            }
            return this;
        }
    });

})(jQuery, this, this.document);