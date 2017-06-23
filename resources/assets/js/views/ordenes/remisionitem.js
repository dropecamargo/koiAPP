/**
* Class RemisionItemView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.RemisionItemView = Backbone.View.extend({

        tagName: 'tr',
        template: _.template( ($('#remision-item-list-tpl').html() || '') ),
        templateInfo: _.template( ($('#remision-show-detail-tpl').html() || '') ),
        events: {
            'click .item-remsion-show-info': 'showDetailRemision'
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
            this.$modalInfo = $('#modal-remision-show-info-component');
            this.remrepu = new app.RemRepuCollection();

            this.parameters.wrapper

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
            // addAll de remrepu1
            this.listenTo( this.remrepu, 'reset', this.addAllRemRepu );
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
        showDetailRemision: function(e){
            var attributes = this.model.toJSON();
            // Render info
            this.$modalInfo.find('.content-modal').empty().html( this.templateInfo( attributes ) );
            this.$wrapperRemrepu = this.$modalInfo.find('#browse-orden-remrepu-show-list');

            //fetch remrepu 
            this.remrepu.fetch({ reset: true, data: { remrepu2_remrepu1: this.model.get('id') } });

            // Open modal
            this.$modalInfo.modal('show');
        },

        /**
        * Render view task by model
        * @param Object mentoringTaskModel Model instance
        */
        addOneRemRepu: function (RemRepuModel) {
            var view = new app.RemRepuItemView({
                model: RemRepuModel,
            });

            this.$wrapperRemrepu.append( view.render().el );           
        },

        /**
        * Render all view tast of the collection
        */
        addAllRemRepu: function () {
            this.remrepu.forEach( this.addOneRemRepu, this );
        },

    });

})(jQuery, this, this.document);