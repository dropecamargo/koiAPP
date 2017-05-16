/**
* Class ShowTerceroView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ShowTerceroView = Backbone.View.extend({

        el: '#terceros-main',
        /**
        * Constructor Method
        */
        initialize : function() {
            // Model exist
            if( this.model.id != undefined ) {

                this.contactsList = new app.ContactsList();
                this.rolList = new app.RolList();
                this.detalleFacturaList = new app.DetalleFactura3List();
                this.$templateTercero = _.template( ($('#add-tercero-cartera-tpl').html() || '') );

                // Reference views
                this.referenceViews();
            }
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            // Contact list
            this.contactsListView = new app.ContactsListView( {
                collection: this.contactsList,
                parameters: {
                    dataFilter: {
                        'tercero_id': this.model.get('id')
                    }
               }
            });

            // Rol list
            this.rolesListView = new app.RolesListView( {
                collection: this.rolList,
                parameters: {
                    edit: false,
                    wrapper: this.$('#wrapper-roles'),
                    dataFilter: {
                        'tercero_id': this.model.get('id')
                    }
               }
            });

            // Detalle list
            this.factura3ListView = new app.Factura3ListView({
                collection: this.detalleFacturaList,
                parameters: {
                    wrapper: this.el,
                    edit: false,
                    call: 'tercero',
                    template: this.$templateTercero,
                    dataFilter: {
                        'tercero': this.model.get('id'),
                    }
                }
            });
        }
    });

})(jQuery, this, this.document);
