/**
* Class CreateSucursalView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateSucursalView = Backbone.View.extend({

        el: '#sucursales-create',
        template: _.template( ($('#add-sucursal-tpl').html() || '') ),
        events: {
            'submit #form-sucursales': 'onStore',
            'ifChanged .changed-location': 'checkLocation',
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            // Attributes
            this.$wraperForm = this.$('#render-form-sucursal');

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

            // References fields
            this.$sucursalDefecto = this.$("#sucursal_defecto");
            this.$locationCheck = this.$("#sucursal_ubicaciones");

            if(this.model.id != undefined){
                this.loadDataSelect();
            }

            this.ready();
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
        /**
        * Change check edit
        */
        checkLocation: function(e){
            var selected = $(e.target).is(':checked');
            if( selected ) {
                this.$sucursalDefecto.prop('required',true);
            }else{
                this.$sucursalDefecto.prop('required',false);
                this.$sucursalDefecto.val('').trigger('change');
            }
        },
        /**
        * Loader data of select locations
        */
        loadDataSelect: function(){
            var _this = this;
            var idSucursal = this.model.get('id');
            if( typeof(idSucursal) !== 'undefined' && !_.isUndefined(idSucursal) && !_.isNull(idSucursal) && idSucursal != '' ){
                $.ajax({
                    url: window.Misc.urlFull( Route.route('ubicaciones.index', {sucursal: idSucursal}) ),
                    type: 'GET',
                    beforeSend: function() {
                        window.Misc.setSpinner( _this.el );
                    }
                })
                .done(function(resp) {
                    window.Misc.removeSpinner( _this.el );
                    _this.$sucursalDefecto.empty().val(0);
                    _this.$sucursalDefecto.append("<option value=></option>");
                    (resp.length > 0) ? _this.$locationCheck.iCheck('check',true) : '' ;

                    _.each(resp, function(item){
                        _this.$sucursalDefecto.append("<option value="+item.id+">"+item.ubicacion_nombre+"</option>");
                        if (_this.model.get('sucursal_defecto') == item.id) {
                            _this.$sucursalDefecto.val(item.id).change();
                        }
                    });
                });
            }
        },
        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();

            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();

            if( typeof window.initComponent.initInputMask == 'function' )
                window.initComponent.initInputMask();

            if( typeof window.initComponent.initICheck == 'function' )
                window.initComponent.initICheck();

            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();
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

                window.Misc.redirect( window.Misc.urlFull( Route.route('sucursales.index')) );
            }
        }
    });

})(jQuery, this, this.document);
