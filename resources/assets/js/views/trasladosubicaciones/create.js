/**
* Class CreateTrasladoUbicacionView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateTrasladoUbicacionView = Backbone.View.extend({

        el: '#trasladosubicaciones-create',
        template: _.template( ($('#add-trasladoubicacion-tpl').html() || '') ),
        events: {
            'change #trasladou1_sucursal': 'changedSucursalUbicacion',
            'submit #form-item-trasladoubicacion': 'onStoreItem',
            'submit #form-trasladoubicacion': 'onStore',
            'click .submit-trasladoubicacion': 'submitTraslado',
        },
        parameters: {
        },

        /**
        * Constructor Method
        */
        initialize : function() {

            // Attributes
            this.$wraperForm = this.$('#render-form-trasladoubicacion');

            this.trasladoUbicacionesList = new app.TrasladoUbicacionesList();

            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /*
        * Render View Element
        */
        render: function() {

            var attributes = this.model.toJSON();
            this.$wraperForm.html( this.template(attributes) );

            // References
            this.$form = this.$('#form-trasladoubicacion');
            this.$formItem = this.$('#form-item-trasladoubicacion');
            this.$origen = this.$('#trasladou1_origen');
            this.$destino = this.$('#trasladou1_destino');

            // Reference views
            this.referenceViews();
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            // Detalle traslado list
            this.productosListView = new app.TrasladoUbicacionesListView({
                collection: this.trasladoUbicacionesList,
                parameters: {
                    wrapper: this.el,
                    edit: true,
                    dataFilter: {
                        'traslado': this.model.get('id')
                    }
                }
            });
        },

        /**
        * Event submit traslado
        */
        submitTraslado: function (e) {
            this.$form.submit();
        },

        /**
        * Event Create Folder
        */
        onStore: function (e) {

            if (!e.isDefaultPrevented()) {

                e.preventDefault();
                var data = window.Misc.formToJson( e.target );
                    data.detalle = this.trasladoUbicacionesList.toJSON();

                this.model.save( data, {patch: true, silent: true} );
            }
        },

        /**
        * Event add item detalle traslado
        */
        onStoreItem: function(e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();
                var data = window.Misc.formToJson( e.target );
                    data.tipo = 'S';
                    data.ubicacion = true;
                    data.sucursal = this.$('#trasladou1_sucursal').val();
                    data.destino = this.$('#trasladou1_destino').val();
                    data.origen = this.$('#trasladou1_origen').val();
                    
                window.Misc.evaluateActionsInventory({
                    'data': data,
                    'wrap': this.$el,
                    'callback': (function (_this) {
                        return function ( action, tipo )
                        {      
                            // Open InventarioActionView
                            if ( _this.inventarioActionView instanceof Backbone.View ){
                                _this.inventarioActionView.stopListening();
                                _this.inventarioActionView.undelegateEvents();
                            }
                            _this.inventarioActionView = new app.InventarioActionView({
                                model: _this.model,
                                collection: _this.trasladoUbicacionesList,
                                parameters: {
                                    data: data,
                                    action: action,
                                    tipo: tipo,
                                    form:_this.$formItem 
                                }
                            });
                            _this.inventarioActionView.render();
                        }
                    })(this)
                }); 
            }
        },
        /**
        * Load data selesct's locations
        */
        changedSucursalUbicacion: function(e){
            e.preventDefault();
            var _this = this;
                id = this.$(e.currentTarget).val();
            // Data select2 origen and destino
            _this.$origen.empty().val(0);
            _this.$destino.empty().val(0);
            if( typeof(id) !== 'undefined' && !_.isUndefined(id) && !_.isNull(id) && id != '' ){
                $.ajax({
                    url: window.Misc.urlFull( Route.route('ubicaciones.index', {sucursal: id}) ),
                    type: 'GET',
                    beforeSend: function() {
                        window.Misc.setSpinner( _this.spinner );
                    }
                })
                .done(function(resp) {
                    window.Misc.removeSpinner( _this.spinner );
                    
                    _this.$origen.append("<option value=></option>");
                    _this.$destino.append("<option value=></option>");
                    _.each(resp, function(item){
                        _this.$origen.append("<option value="+item.id+">"+item.ubicacion_nombre+"</option>");
                        _this.$destino.append("<option value="+item.id+">"+item.ubicacion_nombre+"</option>");
                    });
                })
            }
        },
        /**
        * Load spinner on the request
        */
        loadSpinner: function (model, xhr, opts) {
            window.Misc.setSpinner( this.el );
        },
        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins

            if( typeof window.initComponent.initInputMask == 'function' )
                window.initComponent.initInputMask();
            
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();
            
            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();
            
            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            window.Misc.removeSpinner( this.el );

            if(!_.isUndefined(resp.success)) {
                // response success or error
                var text = resp.success ? '' : resp.errors;
                if( _.isObject( resp.errors ) ) {
                    text = window.Misc.parseErrors(resp.errors);
                }

                if( !resp.success ) {
                    alertify.error(text);
                    return;
                }
                window.Misc.redirect( window.Misc.urlFull( Route.route('trasladosubicaciones.show', { trasladosubicaciones: resp.id})) );
            }
        }
    });

})(jQuery, this, this.document);
