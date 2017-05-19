/**
* Class FacturaItemView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.Factura3ItemView = Backbone.View.extend({

        tagName: 'tr',
        template: _.template( ($('#add-concepto-item-tpl').html() || '') ),
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

            if(this.parameters.call == 'ajustesc'){
                this.template = _.template( ($('#add-item-ajustec-tpl').html() || '') );
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
                this.$el.html( this.parameters.template(attributes) );
            }else if( attributes.call == 'detalle' ){
                this.$el.html( this.parameters.template(attributes) );
            }else{
                this.$el.html( this.template(attributes) );
            }
            return this;
        }
    });

})(jQuery, this, this.document);