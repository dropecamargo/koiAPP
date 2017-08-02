/**
* Class RemisionItemView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {
    app.RemisionItemView = Backbone.View.extend({

        tagName: 'div',
        className: 'panel box box-solid',
        template: _.template( ($('#remision-item-list-tpl').html() || '') ),
        events: {
            'click .render-detalle': 'renderDetailRemision'
        },
        parameters: {
            wrapper: null,
            edit: false,
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize: function(opts){
            //Init Attributes
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            //Init Attributes
            this.remrepu = new app.RemRepuCollection();
            this.listenTo( this.remrepu, 'reset', this.addAllDetalleRemision );
        },

        /*
        * Render View Element
        */
        render: function(){
            var attributes = this.model.toJSON();
                attributes.edit = this.parameters.edit;
            this.$el.html( this.template(attributes) );
            return this;
        },

        renderDetailRemision: function (e){
            if (!e.isDefaultPrevented()) {
                e.preventDefault();
                
                var aria =  this.$(e.currentTarget).attr('aria-expanded');                   
                if ( aria == 'false' ){
                    this.$wraper = this.$el.find('#browse-detalle-remision-list');
                    this.remrepu.fetch({ data: {remrepu2_remrepu1: this.model.get('id')}, reset: true });
                }
            }
        },

        /**
        * Render view task by model
        * @param Object remRepu2Model Model instance
        */
        addOneDetail: function ( remRepu2Model ) {
            var view = new app.RemRepuItemView({
                model: remRepu2Model,
                parameters: {
                    call: 'show',
                }
            });
            this.$wraper.append( view.render().el );
        },

        /**
        * Render all view tast of the collection
        */
        addAllDetalleRemision: function(){
            this.$wraper.find('tbody').html('');
            this.remrepu.forEach( this.addOneDetail, this );
        },
    });

})(jQuery, this, this.document);