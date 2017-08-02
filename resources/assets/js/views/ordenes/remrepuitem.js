/**
* Class RemRepuItemView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.RemRepuItemView = Backbone.View.extend({

        tagName: 'tr',
        template: null,
        parameters: {
            wrapper: null,
            edit: false,
            call: null,
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize: function(opts){
            //Init Attributes
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            if( this.parameters.call == 'index' ){
                this.template = _.template( ($('#legalizacion-item-list-tpl').html() || '') );
            }else{
                this.template = _.template( ($('#remrepu-item-list-tpl').html() || '') );
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

                if(attributes.remrepu1_tipo == 'L'){
                    this.template = _.template( ($('#remrepu-show-list-tpl').html() || '') );
                }
                
            this.$el.html( this.template(attributes) );
            return this;
        },
    });

})(jQuery, this, this.document);