/**
* Class DetalleFacturasItemView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.DetalleFacturasItemView = Backbone.View.extend({

        tagName: 'tr',
        parameters: {
            edit: false,
            template: null
        },

        /**
        * Constructor Method
        */
        initialize: function(opts){
	        // Extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);
            
            // Define default template
            if (this.parameters.template == null ) {
                this.template = _.template( ($('#add-factura-item-tpl').html() || '') );
            }else{
                this.template = this.parameters.template;
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
            this.$el.html( this.template(attributes) );
            return this;
        }
    });

})(jQuery, this, this.document);