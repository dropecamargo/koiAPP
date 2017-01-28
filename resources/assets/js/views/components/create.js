/**
* Class ComponentCreateResourceView  of Backbone
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ComponentCreateResourceView = Backbone.View.extend({

      	el: 'body',
		events: {
            'click .btn-add-resource-koi-component': 'addResource',
            'submit #form-create-resource-component': 'onStore'
		},
        parameters: {
        },

        /**
        * Constructor Method
        */
		initialize: function(opts) {
            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

			// Initialize
            this.$modalComponent = this.$('#modal-add-resource-component');
            this.$wraperError = this.$('#error-resource-component');
            this.$wraperContent = this.$('#content-create-resource-component').find('.modal-body');
		},

		/**
        * Display form modal resource
        */
		addResource: function(e) {
            // References
            this.resource = $(e.currentTarget).attr("data-resource");
            this.$resourceField = $("#"+$(e.currentTarget).attr("data-field"));
            this.parameters = {};

            // stuffToDo resource
            var _this = this,
	            stuffToDo = {
                    'marca' : function() {
                        _this.$modalComponent.find('.inner-title-modal').html('Marca');

                        _this.model = new app.MarcaModel();
                        var template = _.template($('#add-marca-tpl').html());
                        _this.$modalComponent.find('.content-modal').html( template(_this.model.toJSON()) );
                    },
                    'tipo' : function() {
                        _this.$modalComponent.find('.inner-title-modal').html('Tipo');

                        _this.model = new app.TipoModel();
                        var template = _.template($('#add-tipo-tpl').html());
                        _this.$modalComponent.find('.content-modal').html( template(_this.model.toJSON()) );
                    },
                    'modelo' : function() {
                        _this.$modalComponent.find('.inner-title-modal').html('Modelo');

                        _this.model = new app.ModeloModel();
                        var template = _.template($('#add-modelo-tpl').html());
                        _this.$modalComponent.find('.content-modal').html( template(_this.model.toJSON()) );
                    },
                    'estado' : function() {
                        _this.$modalComponent.find('.inner-title-modal').html('Estado');

                        _this.model = new app.EstadoModel();
                        var template = _.template($('#add-estado-tpl').html());
                        _this.$modalComponent.find('.content-modal').html( template(_this.model.toJSON()) );
                    },
                    'dano' : function() {
                        _this.$modalComponent.find('.inner-title-modal').html('Dano');

                        _this.model = new app.DanoModel();
                        var template = _.template($('#add-dano-tpl').html());
                        _this.$modalComponent.find('.content-modal').html( template(_this.model.toJSON()) );
                    },
                    
	                'tercero' : function() {
                        _this.$modalComponent.find('.inner-title-modal').html('Tercero');

                        _this.model = new app.TerceroModel();
                        var template = _.template($('#add-tercero-tpl').html());
                        _this.$modalComponent.find('.content-modal').html( template(_this.model.toJSON()) );
                    },
                    'producto' : function() {
                        _this.$modalComponent.find('.inner-title-modal').html('Producto');

                        _this.model = new app.ProductoModel();
                        var template = _.template($('#add-producto-tpl').html());
                        _this.$modalComponent.find('.content-modal').html( template(_this.model.toJSON()) );
                    }
	            };

            if (stuffToDo[this.resource]) {
                stuffToDo[this.resource]();

                this.$wraperError.hide().empty();

	            // Events
            	this.listenTo( this.model, 'sync', this.responseServer );
            	this.listenTo( this.model, 'request', this.loadSpinner );

                // to fire plugins
                this.ready();

				this.$modalComponent.modal('show');
            }
		},

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();

            if( typeof window.initComponent.initInputMask == 'function' )
                window.initComponent.initInputMask();

            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();

            if( typeof window.initComponent.initICheck == 'function' )
                window.initComponent.initICheck();
        },

        /**
        * Event Create Post
        */
        onStore: function (e) {

            if (!e.isDefaultPrevented()) {

                this.$wraperError.hide().empty();

                e.preventDefault();
                var data = $.extend({}, this.parameters, window.Misc.formToJson( e.target ));

                this.model.save( data, {patch: true} );
            }
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (model, xhr, opts) {
            window.Misc.setSpinner( this.$wraperContent );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            window.Misc.removeSpinner( this.$wraperContent );

            // response success or error
            var text = resp.success ? '' : resp.errors;
            if( _.isObject( resp.errors ) ) {
                text = window.Misc.parseErrors(resp.errors);
            }

            if( !resp.success ) {
                this.$wraperError.empty().append(text);
                this.$wraperError.show();
                return;
            }

            // stuffToDo Response success
            var _this = this,
                stuffToDo = {
                    'marca' : function() {
                        _this.$resourceField.select2({ data: [{id: _this.model.get('id'), text: _this.model.get('marca_modelo')}] }).trigger('change');
                        _this.$resourceField.val(_this.model.get('id')).trigger('change');
                    },
                    'tipo' : function() {
                        _this.$resourceField.select2({ data: [{id: _this.model.get('id'), text: _this.model.get('tipo_nombre')}] }).trigger('change');
                        _this.$resourceField.val(_this.model.get('id')).trigger('change');
                    },
                    'modelo' : function() {
                        _this.$resourceField.select2({ data: [{id: _this.model.get('id'), text: _this.model.get('modelo_nombre')}] }).trigger('change');
                        _this.$resourceField.val(_this.model.get('id')).trigger('change');
                    },
                    'estado' : function() {
                        _this.$resourceField.select2({ data: [{id: _this.model.get('id'), text: _this.model.get('estado_nombre')}] }).trigger('change');
                        _this.$resourceField.val(_this.model.get('id')).trigger('change');
                    },
                    'dano' : function() {
                       _this.$resourceField.select2({ data: [{id: _this.model.get('id'), text: _this.model.get('dano_nombre')}] }).trigger('change');
                        _this.$resourceField.val(_this.model.get('id')).trigger('change');
                    },
                    'tercero' : function() {
                        _this.$resourceField.val(_this.model.get('tercero_nit')).trigger('change');
                    },
                    'producto' : function() {
                        _this.$resourceField.val(_this.model.get('sirvea_codigo')).trigger('change');
                    }
                };

            if (stuffToDo[this.resource]) {
                stuffToDo[this.resource]();

                // Fires libraries js
                if( typeof window.initComponent.initSelect2 == 'function' )
                    window.initComponent.initSelect2();

                this.$modalComponent.modal('hide');
            }
        }
    });


})(jQuery, this, this.document);
