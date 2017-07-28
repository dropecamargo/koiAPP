/**
* Class ShowProductosView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ShowProductoView = Backbone.View.extend({

        el: '#producto-show',
        events: {
            'click .get-info-availability': 'getInfoAvailability'
        },

        /**
        * Constructor Method
        */
        initialize: function() {
           
           this.$('#browse-prodbode-table').hide();
            // Collection the prodbode
            this.prodbodeList = new app.ProdbodeList();
        },
        
        /**
        * Event show series products father's
        */
        getInfoAvailability: function(e){
            e.preventDefault();
            
            // Model exist
            if( this.prodbodeList.length == 0 ) {
               
               this.$('#browse-prodbode-table').show();
                // Reference views
                this.referenceViews();
            }
        },

        /**
        * Reference to views
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
