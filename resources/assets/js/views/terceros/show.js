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
                this.detalleCarteraTercero = new app.DetalleCarteraTercero();
                this.gestionCobroList = new app.GestionCobrosCollection();
                this.detallecuotaProveedor = new app.DetalleFacturap3List();
                
                this.$templateTercero = _.template( ($('#add-tercero-cartera-tpl').html() || '') );
                this.$templateProveedor = _.template( ($('#show-facturap3-tpl').html() || '') );

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
            // Gestion Cobro list
            this.gestionCobroListView = new app.GestionCobroListView( {
                collection: this.gestionCobroList,
                parameters: {
                    dataFilter: {
                        'tercero': this.model.get('id')
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

            // Detalle list cartera
            this.factura3ListView = new app.Factura3ListView({
                collection: this.detalleCarteraTercero,
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
            // Detalle list factura proveedor
            this.factura3ListView = new app.Facturap3ListView({
                collection: this.detallecuotaProveedor,
                parameters: {
                    wrapper: this.el,
                    edit: false,
                    call: 'tercero',
                    template: this.$templateProveedor,
                    dataFilter: {
                        'tercero': this.model.get('id'),
                    }
                }
            });
        }
    });

})(jQuery, this, this.document);
