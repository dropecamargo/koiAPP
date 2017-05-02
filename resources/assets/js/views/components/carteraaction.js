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
            
            // Collection producto vence
            this.detalleReciboList = new app.DetalleReciboList();

            this.listenTo( this.detalleReciboList, 'add', this.addOne );
            this.listenTo( this.detalleReciboList, 'reset', this.addAll );
            
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.collection, 'sync', this.responseServer );
        },

        /*
        * Render View Element
        */
        render: function() {
            var resp = this.parameters,
                _this = this,
                stuffToDo = {
                    'modalCartera': function() {
                        if (resp.tipo == 'E') {
                            _this.$modal.find('.content-modal').empty().html(_this.template( ));

                            // Reference inventario
                            _this.reference(resp);
                        }else{
                            // Reference inventario
                            _this.reference(resp);
                        }
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
            if( typeof window.initComponent.initInputMask == 'function' )
                window.initComponent.initInputMask();

            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();

            if( typeof window.initComponent.initICheck == 'function' )
                window.initComponent.initICheck();
        },
        /**
        * Reference add Series
        */
        reference: function(atributes) {
            this.$wraper = this.$('#modal-wrapper-concepto-factura');
            this.$wraperForm = this.$modal.find('.content-modal');
            this.$wraperError = this.$('#error-concepto-factura');

            this.$wraperConcepto = this.$('#browse-concepto-factura-list');
            // Hide errors
            this.$wraperError.hide().empty();
            // Open modal
            this.$modal.modal('show');

        },
        /**
        * Render view task by model
        * @param Object Model instance
        */
        addOne: function (recibo2Model) {
            var view = new app.DetalleRecibosView({
                model: recibo2Model,
                parameters:{
                }
            });
            
            recibo2Model.view = view;
            this.$wraper.append( view.render().el );
            this.ready();
        },

        /*
        *Render all view tast of the collection
        */
        addAll:function(){
            var _this = this;
            this.detalleReciboList.forEach(function(model, index) {
                _this.addOne(model)
            });
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