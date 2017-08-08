/**
* Class ProductoActionView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ProductoActionView = Backbone.View.extend({

        el: '#producto-content-section',
        templateMachine: _.template(($('#edit-machine-tpl').html() || '')),
        templateSerie: _.template(($('#add-series-producto-tpl').html() || '')),
        events: {
            'click .submit-generic': 'submitForm',
            'submit #form-generic-producto': 'onStore',
        },
        parameters: {
            data: {},
            action: {}
        },

        /**
        * Constructor Method
        */
        initialize : function( opts ) {
            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            this.$modalGeneric = $('#modal-producto-generic');
            this.$formGeneric =  this.$('#form-generic-producto');
        },

        /*
        * Render View Element
        */
        render: function() {
            if ( this.parameters.call == 'M') {
                this.$modalGeneric.find('.modal-title').text( 'Producto - Editar máquina' );
                this.$modalGeneric.find('.content-modal').empty().html( this.templateMachine( this.parameters.data ) );
            }else{
                this.$modalGeneric.find('.modal-title').text( 'Producto - Agregar serie' );
                this.$modalGeneric.find('.content-modal').empty().html( this.templateSerie( this.parameters.data ) );
            }
            this.ready();
		},

        /**
        * Sumbit form
        */
        submitForm: function(e){
            this.$formGeneric.submit();
        },

        /**
        *   Event store
        */
        onStore: function(e){
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );

                if( this.parameters.call == 'M' ){
                    this.updateMachine( data );
                }else{
                    this.storeSerie( data );
                }
            }
        },

        updateMachine: function( data ){
            var _this = this;
                data = data;
                data.producto_id = this.model.get('id');

            // Update machine
            $.ajax({
                url: window.Misc.urlFull( Route.route( 'productos.machine') ),
                data: data,
                type: 'PUT',
                beforeSend: function() {
                    window.Misc.setSpinner( _this.el );
                }
            })
            .done(function(resp) {
                window.Misc.removeSpinner( _this.el );
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

                    _this.$modalGeneric.modal('hide');
                    window.Misc.successRedirect( resp.msg, window.Misc.urlFull( Route.route('productos.show', { productos: _this.model.get('id')})) );
                }
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                window.Misc.removeSpinner( _this.el );
                alertify.error(thrownError);
            });
        },

        storeSerie: function( data ){
            var _this = this;
                data = data;
                data.producto_id = this.model.get('id');

            // StoreSerie
            $.ajax({
                url: window.Misc.urlFull( Route.route( 'productos.storeserie') ),
                data: data,
                type: 'POST',
                beforeSend: function() {
                    window.Misc.setSpinner( _this.el );
                }
            })
            .done(function(resp) {
                window.Misc.removeSpinner( _this.el );
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

                    _this.$modalGeneric.modal('hide');
                    alertify.success(resp.msg);
                }
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                window.Misc.removeSpinner( _this.el );
                alertify.error(thrownError);
            });
        },

    	/**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();

            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();

            if( typeof window.initComponent.initDatePicker == 'function' )
                window.initComponent.initDatePicker();

            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();
        },
    });

})(jQuery, this, this.document);
