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
            this.visitap = new app.VisitapCollection();
            // this.contadoresp = new app.ContadorespCollection();
            
            // Events Listener
            this.listenTo( this.model, 'change', this.render );
            
            // addAll de visitasp
            this.listenTo( this.visitap, 'reset', this.addAllVisitasp );

            // // addAll de contadoresp
            // this.listenTo( this.contadoresp, 'reset', this.addAllContadoresp );
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

        /*
        * Show detalle visita 
        */

        showInfoVisita: function(){
            var attributes = this.model.toJSON();

            // Render info
            this.$modalInfo.find('.content-modal').empty().html( this.templateInfo( attributes ) );
            this.$wrapperVisitasp = this.$modalInfo.find('#browse-orden-visitasp-show-list');
            this.$wrapperContadoresp = this.$modalInfo.find('#browse-orden-contadoresp-show-list');
    
            //fetch vistas 
            this.visitap.fetch({ reset: true, data: { visitap: this.model.get('id') } });
            // this.contadoresp.fetch({ reset: true, data: { contadoresp: this.model.get('id') } });
            // Open modal
           
            this.$modalInfo.modal('show');
        },

        /**
        * Render view task by model
        * @param Object mentoringTaskModel Model instance
        */
        addOneVisitasp: function (VisitapModel) {
            var view = new app.VisitaspItemView({
                model: VisitapModel,
            });

            this.$wrapperVisitasp.append( view.render().el );           
        },

        addOneContadoresp: function (ContadorespModel) {
            var view = new app.ContadoresItemView({
                model: ContadorespModel,
                parameters:{
                    edit:false
                }
            });

            this.$wrapperContadoresp.append( view.render().el );

          
                    
        },

        /**
        * Render all view tast of the collection
        */
        addAllVisitasp: function () {
            this.visitap.forEach( this.addOneVisitasp, this );
        },

        addAllContadoresp: function () {
            this.contadoresp.forEach( this.addOneContadoresp, this );
        },
    });

})(jQuery, this, this.document);