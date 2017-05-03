/**
* Class CarteraActionView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});
(function ($, window, document, undefined) {
    app.CarteraActionView = Backbone.View.extend({
    	el: 'body',

        template: _.template( ($('#add-concepto-factura-tpl').html() || '') ),
    	events:{ 
            'submit #form-concepto-factura-component': 'onStoreItem',
    	},
        parameters: {
            data: { },
        },

        /**
        * Constructor Method
        */
        initialize : function( opts ) {
            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            this.$modal = this.$('#modal-concepto-factura-component');
            
            // Collection 
            this.detalleFacturaList = new app.DetalleFacturaList();

            this.listenTo( this.detalleFacturaList, 'add', this.addOne );
            this.listenTo( this.detalleFacturaList, 'reset', this.addAll );
            
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.collection, 'sync', this.responseServer );

            this.ready();
        },

        /*
        * Render View Element
        */
        render: function() {
            var resp = this.parameters,
                _this = this,
                stuffToDo = {
                    'modalCartera': function() {
                        _this.$modal.find('.content-modal').empty().html(_this.template());

                        // Reference 
                        _this.reference(resp);
                    },
                    
                };
            if (stuffToDo[resp.action]) {
                stuffToDo[resp.action]();
            }
		},
    	/**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initICheck == 'function' )
                window.initComponent.initICheck();

            if( typeof window.initComponent.initInputMask == 'function' )
                window.initComponent.initInputMask();
        },

        /**
        * Reference
        */
        reference: function(atributes) {
            this.$wraper = this.$('#modal-wrapper-concepto-factura');
            this.$wraperForm = this.$modal.find('.content-modal');
            this.$wraperError = this.$('#error-concepto-factura');

            this.$wraperConcepto = this.$('#browse-concepto-factura-list');
    
            this.detalleFacturaList.fetch({ reset: true, data: { tercero: atributes.data.tercero } });

            // Hide errors
            this.$wraperError.hide().empty();

            // Open modal
            this.$modal.modal('show');
        },
        /**
        * Render view task by model
        * @param Object Model instance
        */
        addOne: function (factura3Model) {
            var view = new app.FacturaItemView({
                model: factura3Model,
                parameters:{
                }
            });
            
            factura3Model.view = view;
            this.$wraperConcepto.append( view.render().el );
            this.ready();
        },

        /*
        *Render all view tast of the collection
        */
        addAll:function(){
            var _this = this;
            if( this.detalleFacturaList.length > 0){
                this.detalleFacturaList.forEach(function(model, index) {
                    _this.addOne(model)
                });
            }else{
                _this.addOne( factura3Model = new app.Factura3Model );
            }
        },

        responseServer: function ( model, resp, opts ) {
            if(!_.isUndefined(resp.success)) {
                if( resp.success ) {
                    // Close modals
                    this.$modal.modal('hide');
                }
            }
        }
    });
})(jQuery, this, this.document);