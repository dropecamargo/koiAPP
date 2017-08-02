/**
* Class ShowAjusteView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ShowAjusteView = Backbone.View.extend({

        el: '#ajuste-show',
        events:{
            'click .export-alistar': 'exportAlistar',
            'click .export-ajuste': 'exportAjuste'
        },

        /**
        * Constructor Method
        */
        initialize : function() {

            // Model exist
            if( this.model.id != undefined ) {
                this.detalleAjuste = new app.AjustesDetalleCollection();

                // Reference views
                this.referenceViews();
            }

        },

        /**
        * reference to views
        */
        referenceViews: function () {
            this.detalleAjustesView = new app.DetalleAjustesView( {
                collection: this.detalleAjuste,
                parameters: {
                    wrapper: this.el,
                    edit: false,
                    dataFilter: {
                        'id': this.model.get('id')
                    }
               }
            });
        },

        /*
        * Redirect export pdf
        */
        exportAjuste:function(e){
            e.preventDefault(); 

            // Redirect to pdf
            window.open( window.Misc.urlFull( Route.route('ajustes.exportar', { ajustes: this.model.get('id') })) );
        },
        /*
        * Redirect export pdf
        */
        exportAlistar:function(e){
            e.preventDefault(); 

            // Redirect to pdf
            window.open( window.Misc.urlFull( Route.route('ajustes.alistar', { ajustes: this.model.get('id') })) );
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
            
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();
            
            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();
            
            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();

            if( typeof window.initComponent.initDatePicker == 'function' )
                window.initComponent.initDatePicker();
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
               
            }
        }
    });

})(jQuery, this, this.document);
