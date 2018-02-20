/**
* Class CreateProductoView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateProductoView = Backbone.View.extend({

        el: '#productos-create',
        template: _.template( ($('#add-producto-tpl').html() || '') ),
        events: {
            'ifChecked #producto_maneja_serie': 'serieChange',
            'ifChecked #producto_metrado': 'metradoChange',
            'ifChecked #producto_vence': 'venceChange',
            'change #producto_marca': 'changeMarca',
            'submit #form-productos': 'onStore',
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            // Attributes
            this.$wraperForm = this.$('#render-form-producto');

            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /**
        * Event Create Folder
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                this.model.save( data, {patch: true, silent: true} );
            }
        },

        /*
        * Render View Element
        */
        render: function() {
            var attributes = this.model.toJSON();
            this.$wraperForm.html( this.template(attributes) );

            // References
            this.$inputSerie = this.$("#producto_maneja_serie");
            this.$inputMetrado = this.$("#producto_metrado");
            this.$inputVence = this.$("#producto_vence");
            this.$modelo = this.$("#producto_modelo");

            this.ready();
        },

        /*
        *Function change check Product handles serie
        */
        serieChange: function (e) {
            var selected = $(e.target).is(':checked');
            if( selected ) {
                this.$inputMetrado.iCheck('uncheck');
                this.$inputVence.iCheck('uncheck');
            }
        },

        /*
        *Function change check Product vence
        */
        venceChange: function (e) {
            var selected = $(e.target).is(':checked');
            if( selected ) {
                this.$inputMetrado.iCheck('uncheck');
                this.$inputSerie.iCheck('uncheck');
            }
        },

        /*
        *Function change check Product metrado
        */
        metradoChange: function (e) {
            var selected = $(e.target).is(':checked');
            if( selected ) {
                this.$inputSerie.iCheck('uncheck');
                this.$inputVence.iCheck('uncheck');
            }
        },

        changeMarca: function(e) {
            var _this = this;
                marca = this.$(e.currentTarget).val();

            if( typeof(marca) !== 'undefined' && !_.isUndefined(marca) && !_.isNull(marca) && marca != '' ){
                $.ajax({
                    url: window.Misc.urlFull( Route.route('modelos.index', {marca: marca}) ),
                    type: 'GET',
                    beforeSend: function() {
                        window.Misc.setSpinner( _this.el );
                    }
                })
                .done(function(resp) {
                    window.Misc.removeSpinner( _this.el );
                    _this.$modelo.empty().val(0).removeAttr('disabled');

                    _this.$modelo.append("<option value=></option>");
                    _.each(resp, function( modelo ){
                        _this.$modelo.append("<option value="+modelo.id+">"+modelo.modelo_nombre+"</option>");
                    });

                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    window.Misc.removeSpinner( _this.el );
                    alertify.error(thrownError);
                });
            }else{
                this.$modelo.empty().val(0).attr('disabled', 'disabled');
            }
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();

            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();

            if( typeof window.initComponent.initICheck == 'function' )
                window.initComponent.initICheck();

            if( typeof window.initComponent.initInputMask == 'function' )
                window.initComponent.initInputMask();
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (model, xhr, opts) {
            window.Misc.setSpinner( this.el );
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

                window.Misc.redirect( window.Misc.urlFull( Route.route('productos.show', { productos: resp.id})) );
            }
        }
    });

})(jQuery, this, this.document);
