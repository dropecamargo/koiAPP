/**
* Class VisitaItemView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.VisitasItemView = Backbone.View.extend({

        tagName: 'tr',
        template: _.template( ($('#visita-item-list-tpl').html() || '') ),
        templateInfo: _.template( ($('#show-info-visita-tpl').html() || '') ),
        events: {
           'click .item-visita-show-info': 'showInfoVisita'
        },
        parameters: {
            edit: false,
            last: false
        },

        /**
        * Constructor Method
        */
        initialize: function(opts){

            //Init Attributes
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            //this.parameters.wrapper
            this.$modalInfo = $('#modal-visita-show-info-component');
            
            // Events Listener
            this.listenTo( this.model, 'change', this.render );
        },

        /*
        * Render View Element
        */
        render: function(){
            var attributes = this.model.toJSON();
                attributes.edit = this.parameters.edit;
                attributes.last = false;
                
            if (this.parameters.last == this.model.get('id')) {
                attributes.last = true;
            }
            this.$el.html( this.template(attributes) );
            
            return this;
        },

        /*
        * Show detalle visita 
        */

        showInfoVisita: function(){
            var attributes = this.model.toJSON();
            // Render info
            this.$modalInfo.find('.content-modal').empty().html( this.templateInfo( attributes ) );
            // this.$wrapperVisitasp = this.$modalInfo.find('#browse-orden-visitasp-show-list');
            // Open modal
            this.$modalInfo.modal('show');
        },


    });

})(jQuery, this, this.document);