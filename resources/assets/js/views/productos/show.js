/**
* Class ShowProductosView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ShowProductoView = Backbone.View.extend({

        el: '#content-show',
        template: _.template( ($('#add-ubicacion-tpl').html() || '') ),
        events: {
            'click .get-series': 'getSeries',
            'click .add-ubicacion': 'addUbicacion',
            'submit #form-ubicacion-component': 'updateComponent'
        },

        /**
        * Constructor Method
        */
        initialize: function() {
            this.prodbodeList = new app.ProdbodeList();
        },

        getSeries: function(e){
            e.preventDefault();
            // Model exist
            if( this.prodbodeList.length == 0 ) {
                // Reference views
                this.referenceViews();
            }
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            // Detalle asignaciones list
            this.prodbodeListView = new app.ProdbodeListView({
                collection: this.prodbodeList,
                parameters: {
                    wrapper: this.$('#wrapper-series'),
                    dataFilter: {
                        'producto_id': this.model.get('id')
                    }
                }
            });
        },
    });

})(jQuery, this, this.document);
