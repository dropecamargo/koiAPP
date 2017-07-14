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
            this.el = this.$modalInfo.find('#browse-legalizacion-list');

            // Open modal
            this.$modalInfo.modal('show');

            this.referenceViews();
        },

        referenceViews: function(){
            this.remrepuView = new app.RemRepuView( {
                collection: this.remrepu,
                el: this.el,
                parameters: {
                    call: 'show',
                    dataFilter: {
                        remrepu2_remrepu1: this.model.get('id')
                    }
                }
            });
        },
    });

})(jQuery, this, this.document);