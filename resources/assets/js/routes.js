/**
* Class AppRouter  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.AppRouter = new( Backbone.Router.extend({
        routes : {
            //Login
            'login(/)': 'getLogin',

            /*
            |-----------------------
            | Administracion
            |-----------------------
            */

            //Terceros
            'terceros(/)': 'getTercerosMain',
            'terceros/create(/)': 'getTercerosCreate',
            'terceros/:tercero(/)': 'getTercerosShow',
            'terceros/:tercero/edit(/)': 'getTercerosEdit',

            //Empresa
            'empresa(/)': 'getEmpresaEdit',

            //Actividades
            'actividades(/)': 'getActividadesMain',
            'actividades/create(/)': 'getActividadesCreate',
            'actividades/:actividad/edit(/)': 'getActividadesEdit',

            //Sucursales
            'sucursales(/)': 'getSucursalesMain',
            'sucursales/create(/)': 'getSucursalesCreate',
            'sucursales/:sucursal/edit(/)': 'getSucursalesEdit',

            //Ubicaciones
            'ubicaciones(/)': 'getUbicacionesMain',
            'ubicaciones/create(/)': 'getUbicacionCreate',
            'ubicaciones/:ubicacion/edit(/)': 'getUbicacionEdit',

            //Regionales
            'regionales(/)': 'getRegionalesMain',
            'regionales/create(/)': 'getRegionalesCreate',
            'regionales/:regional/edit(/)': 'getRegionalesEdit',

            //Documento
            'documento(/)': 'getDocumentoMain',
            'documento/create(/)': 'getDocumentoCreate',
            'documento/:documentos/edit(/)':'getDocumentoEdit',

            //Departamentos & Municipios
            'departamentos(/)': 'getDepartamentosMain',
            'municipios(/)': 'getMunicipiosMain',

            // Paises
            'paises(/)': 'getPaisesMain',

            'puntosventa(/)': 'getPuntosVentaMain',
            'puntosventa/create(/)': 'getPuntosVentaCreate',
            'puntosventa/:puntoventa/edit(/)': 'getPuntosVentaEdit',

            //Tipos Actividad
            'tiposactividad(/)': 'getTiposActividadMain',
            'tiposactividad/create(/)': 'getTiposActividadCreate',
            'tiposactividad/:tipoactividad/edit(/)': 'getTiposActividadEdit',

            'tiposajuste(/)': 'getTiposAjusteMain',
            'tiposajuste/create(/)': 'getTipoAjusteCreate',
            'tiposajuste/:tipoajuste/edit(/)': 'getTipoAjusteEdit',

            //Tipos Traslados
            'tipostraslados(/)': 'getTiposTrasladosMain',
            'tipostraslados/create(/)': 'getTipoTrasladoCreate',
            'tipostraslados/:tipostraslados/edit(/)': 'getTipoTrasladoEdit',

            //permisos
            'permisos(/)': 'getPermisosMain',
            'modulos(/)': 'getModulosMain',

            'roles(/)': 'getRolesMain',
            'roles/create(/)': 'getRolesCreate',
            'roles/:rol/edit(/)': 'getRolesEdit',

            /*
            |----------------------
            | Comercial
            |----------------------
            */
            'presupuestoasesor(/)': 'getPresupuestoAsesorMain',

            'pedidosc(/)': 'getPedidoscMain',
            'pedidosc/create(/)': 'getPedidoscCreate',
            'pedidosc/:pedidosc(/)': 'getPedidoscShow',

            'conceptoscomercial(/)': 'getConceptosComMain',
            'conceptoscomercial/create(/)': 'getConceptoComCreate',
            'conceptoscomercial/:conceptoscomercial/edit(/)': 'getConceptoComEdit',

            'gestionescomercial(/)': 'getGestionesComercialMain',
            'gestionescomercial/create(/)': 'getGestionComercialCreate',

            /*
            |-----------------------
            | Contabilidad
            |-----------------------
            */
            'documentos(/)': 'getDocumentosMain',
            'documentos/create(/)': 'getDocumentosCreate',
            'documentos/:documento/edit(/)':'getDocumentosEdit',

            'folders(/)': 'getFoldersMain',
            'folders/create(/)': 'getFoldersCreate',
            'folders/:folder/edit(/)':'getFoldersEdit',

            'plancuentas(/)': 'getPlanCuentasMain',
            'plancuentas/create(/)': 'getPlanCuentasCreate',
            'plancuentas/:plancuenta/edit(/)': 'getPlanCuentasEdit',

            'centroscosto(/)': 'getCentrosCostoMain',
            'centroscosto/create(/)': 'getCentrosCostoCreate',
            'centroscosto/:centrocosto/edit(/)': 'getCentrosCostoEdit',

            'asientos(/)': 'getAsientosMain',
            'asientos/create(/)': 'getAsientosCreate',
            'asientos/:asientos(/)': 'getAsientosShow',
            'asientos/:asiento/edit(/)': 'getAsientosEdit',

            /*
            |-----------------------
            | Inventario
            |-----------------------
            */
            'productos(/)': 'getProductosMain',
            'productos/create(/)': 'getProductosCreate',
            'productos/:producto(/)': 'getProductosShow',
            'productos/:producto/edit(/)': 'getProductosEdit',

            'pedidos(/)': 'getPedidosMain',
            'pedidos/create(/)': 'getPedidosCreate',
            'pedidos/:pedido/edit(/)': 'getPedidosEdit',
            'pedidos/:pedidos(/)': 'getPedidoShow',

            'marcas(/)': 'getMarcasMain',
            'marcas/create(/)': 'getMarcasCreate',
            'marcas/:marcas/edit(/)': 'getMarcasEdit',

            'categorias(/)': 'getCategoriasMain',
            'categorias/create(/)': 'getCategoriasCreate',
            'categorias/:categorias/edit(/)': 'getCategoriasEdit',

            'subcategorias(/)': 'getSubCategoriasMain',
            'subcategorias/create(/)': 'getSubCategoriasCreate',
            'subcategorias/:subcategorias/edit(/)': 'getSubCategoriasEdit',

            'impuestos(/)': 'getImpuestosMain',
            'impuestos/create(/)': 'getImpuestoCreate',
            'impuestos/:impuestos/edit(/)': 'getImpuestoEdit',

            'modelos(/)': 'getModelosMain',
            'modelos/create(/)': 'getModelosCreate',
            'modelos/:modelo/edit(/)': 'getModelosEdit',

            'lineas(/)': 'getLineasMain',
            'lineas/create(/)': 'getLineaCreate',
            'lineas/:lineas/edit(/)': 'getLineasEdit',

            'unidades(/)': 'getUnidadesMain',
            'unidades/create(/)': 'getUnidadesCreate',
            'unidades/:unidad/edit(/)': 'getUnidadesEdit',

            'unidadesnegocio(/)': 'getUnidadesNegocioMain',
            'unidadesnegocio/create(/)': 'getUnidadNegocioCreate',
            'unidadesnegocio/:unidadnegocio/edit(/)': 'getUnidadNegocioEdit',

            'servicios(/)': 'getServiciosMain',
            'servicios/create(/)': 'getServiciosCreate',
            'servicios/:servicios/edit(/)': 'getServiciosEdit',

            'ajustes(/)': 'getAjustesMain',
            'ajustes/create(/)': 'getAjustesCreate',
            'ajustes/:ajustes(/)': 'getAjusteShow',

            'traslados(/)': 'getTrasladosMain',
            'traslados/create(/)': 'getTrasladosCreate',
            'traslados/:traslado(/)': 'getTrasladosShow',

            'trasladosubicaciones(/)': 'getTrasladosUbicacionesMain',
            'trasladosubicaciones/create(/)': 'getTrasladoUbicacionCreate',
            'trasladosubicaciones/:traslado(/)': 'getTrasladoUbicacionShow',

            /*
            |-----------------------
            | Cartera
            |-----------------------
            */
            'autorizacionesca(/)': 'getAutorizacionesCaMain',
            'autorizacionesca/:autorizacionesca(/)': 'getAutorizacionesCaShow',

            'bancos(/)': 'getBancosMain',
            'bancos/create(/)': 'getBancosCreate',
            'bancos/:bancos/edit(/)': 'getBancosEdit',

            'causas(/)': 'getCausasMain',
            'causas/create(/)': 'getCausaCreate',
            'causas/:causas/edit(/)': 'getCausaEdit',

            'cuentabancos(/)': 'getCuentaBancosMain',
            'cuentabancos/create(/)': 'getCuentaBancosCreate',
            'cuentabancos/:cuentabancos/edit(/)': 'getCuentaBancosEdit',

            'mediopagos(/)': 'getMedioPagosMain',
            'mediopagos/create(/)': 'getMedioPagosCreate',
            'mediopagos/:mediopagos/edit(/)': 'getMedioPagosEdit',

            'conceptocobros(/)': 'getConceptosCobMain',
            'conceptocobros/create(/)': 'getConceptoCobCreate',
            'conceptocobros/:conceptocobros/edit(/)': 'getConceptoCobEdit',

            'conceptosrc(/)': 'getConceptosrcMain',
            'conceptosrc/create(/)': 'getConceptosrcCreate',
            'conceptosrc/:conceptosrc/edit(/)': 'getConceptosrcEdit',

            'conceptonotas(/)': 'getConceptoNotasMain',
            'conceptonotas/create(/)': 'getConceptoNotasCreate',
            'conceptonotas/:conceptonotas/edit(/)': 'getConceptoNotasEdit',

            'notas(/)': 'getNotasMain',
            'notas/create(/)': 'getNotasCreate',
            'notas/:notas(/)': 'getNotasShow',
            
            'facturas(/)': 'getFacturasMain',
            'facturas/create(/)': 'getFacturaCreate',
            'facturas/:facturas(/)': 'getFacturaShow',

            'recibos(/)': 'getRecibosMain',
            'recibos/create(/)': 'getRecibosCreate',
            'recibos/:recibos(/)': 'getRecibosShow',

            'conceptosajustec(/)': 'getConceptosAjustecMain',
            'conceptosajustec/create(/)': 'getConceptosAjustecCreate',
            'conceptosajustec/:conceptosajustec/edit(/)': 'getConceptosAjustecEdit',

            'ajustesc(/)': 'getAjustescMain',
            'ajustesc/create(/)': 'getAjustescCreate',
            'ajustesc/:ajustesc(/)': 'getAjustescShow',

            'devoluciones(/)': 'getDevolucionesMain',
            'devoluciones/create(/)': 'getDevolucionesCreate',
            'devoluciones/:devoluciones(/)': 'getDevolucionesShow',
    
            'anticipos(/)': 'getAnticiposMain',
            'anticipos/create(/)': 'getAnticipoCreate',
            'anticipos/:anticipos(/)': 'getAnticiposShow',

            'cheques(/)': 'getChequesMain',
            'cheques/create(/)': 'getChequeCreate',
            'cheques/:cheques(/)': 'getChequeShow',

            'chequesdevueltos(/)': 'getChequesDevueltosMain',

            'gestioncobros(/)': 'getGestionCobrosMain',
            'gestioncobros/create(/)': 'getGestionCobroCreate',

            /*
            |----------------------
            | Tecnico
            |----------------------
            */
            'conceptostecnico(/)': 'getConceptosTecMain',
            'conceptostecnico/create(/)': 'getConceptoTecCreate',
            'conceptostecnico/:conceptostecnico/edit(/)': 'getConceptoTecEdit',

            'tiposorden(/)': 'getTiposOrdenMain',
            'tiposorden/create(/)': 'getTiposOrdenCreate',
            'tiposorden/:tiposorden/edit(/)': 'getTiposOrdenEdit',

            'solicitantes(/)': 'getSolicitantesMain',
            'solicitantes/create(/)': 'getSolicitantesCreate',
            'solicitantes/:solicitantes/edit(/)': 'getSolicitantesEdit',

            'danos(/)': 'getDanosMain',
            'danos/create(/)': 'getDanosCreate',
            'danos/:danos/edit(/)': 'getDanosEdit',

            'ordenes(/)': 'getOrdenesMain',
            'ordenes/create(/)': 'getOrdenesCreate',
            'ordenes/:orden/edit(/)': 'getOrdenesEdit',
            'ordenes/:orden(/)': 'getOrdenesShow',

            'prioridades(/)': 'getPrioridadesMain',
            'prioridades/create(/)': 'getPrioridadesCreate',
            'prioridades/:prioridades/edit(/)': 'getPrioridadesEdit',

            'gestionestecnico(/)': 'getGestionesTecnicoMain',
            'gestionestecnico/create(/)': 'getGestionTecnicoCreate',

            'sitios(/)': 'getSitiosMain',
            'sitios/create(/)': 'getSitiosCreate',
            'sitios/:sitios/edit(/)': 'getSitiosEdit',

            'agendatecnica(/)': 'getAgendaTecnicaMain',
        },

        /**
        * Parse queryString to object
        */
        parseQueryString : function(queryString) {
            var params = {};
            if(queryString) {
                _.each(
                    _.map(decodeURI(queryString).split(/&/g),function(el,i){
                        var aux = el.split('='), o = {};
                        if(aux.length >= 1){
                            var val = undefined;
                            if(aux.length == 2)
                                val = aux[1];
                            o[aux[0]] = val;
                        }
                        return o;
                    }),
                    function(o){
                        _.extend(params,o);
                    }
                );
            }
            return params;
        },

        /**
        * Constructor Method
        */
        initialize : function ( opts ){
            // Initialize resources
            this.componentGlobalView = new app.ComponentGlobalView();
            this.componentAddressView = new app.ComponentAddressView();
            this.componentSearchTerceroView = new app.ComponentSearchTerceroView();
            this.componentSearchProductoView = new app.ComponentSearchProductoView();
            this.componentTerceroView = new app.ComponentTerceroView();
            this.componentReporteView = new app.ComponentReporteView();
            this.componentCreateResourceView = new app.ComponentCreateResourceView();
            this.componentSearchCuentaView = new app.ComponentSearchCuentaView();
            this.componentSearchContactoView = new app.ComponentSearchContactoView();
            this.componentConsecutiveView = new app.ComponentConsecutiveView();
            this.componentPedidocView = new app.ComponentSearchPedidocView();
            this.componentFacturaView = new app.ComponentSearchFacturaView();

      	},

        /**
        * Start Backbone history
        */
        start: function () {
            var config = { pushState: true };

            if( document.documentURI.search(/(dev-signsupply)/gi) != '-1' ) {
                config.root = '/dev-signsupply/public/';

            }else if( document.domain.search(/(104.236.57.82|localhost)/gi) != '-1' ) {
                config.root = '/signsupply/public/';
            }

            Backbone.history.start( config );
        },

        /**
        * show view in Calendar Event
        * @param String show
        */
        getLogin: function () {

            if ( this.loginView instanceof Backbone.View ){
                this.loginView.stopListening();
                this.loginView.undelegateEvents();
            }

            this.loginView = new app.UserLoginView( );
        },

        /*------------------------
        | Administracion
        /*-----------------------*/

        //Empresa
        getEmpresaEdit: function () {
            this.empresaModel = new app.EmpresaModel();

            if ( this.createEmpresaView instanceof Backbone.View ){
                this.createEmpresaView.stopListening();
                this.createEmpresaView.undelegateEvents();
            }

            this.createEmpresaView = new app.CreateEmpresaView({ model: this.empresaModel });
            this.empresaModel.fetch();
        },

        // Tercero
        getTercerosMain: function () {

            if ( this.mainTerceroView instanceof Backbone.View ){
                this.mainTerceroView.stopListening();
                this.mainTerceroView.undelegateEvents();
            }

            this.mainTerceroView = new app.MainTerceroView( );
        },

        getTercerosCreate: function () {
            this.terceroModel = new app.TerceroModel();

            if ( this.createTerceroView instanceof Backbone.View ){
                this.createTerceroView.stopListening();
                this.createTerceroView.undelegateEvents();
            }

            this.createTerceroView = new app.CreateTerceroView({ model: this.terceroModel });
            this.createTerceroView.render();
        },

        getTercerosShow: function (tercero) {
            this.terceroModel = new app.TerceroModel();
            this.terceroModel.set({'id': tercero}, {'silent':true});

            if ( this.showTerceroView instanceof Backbone.View ){
                this.showTerceroView.stopListening();
                this.showTerceroView.undelegateEvents();
            }

            this.showTerceroView = new app.ShowTerceroView({ model: this.terceroModel });
        },

        getTercerosEdit: function (tercero) {
            this.terceroModel = new app.TerceroModel();
            this.terceroModel.set({'id': tercero}, {'silent':true});

            if ( this.createTerceroView instanceof Backbone.View ){
                this.createTerceroView.stopListening();
                this.createTerceroView.undelegateEvents();
            }

            this.createTerceroView = new app.CreateTerceroView({ model: this.terceroModel });
            this.terceroModel.fetch();
        },

        /**
        * show view main actividades
        */
        getActividadesMain: function () {

            if ( this.mainActividadView instanceof Backbone.View ){
                this.mainActividadView.stopListening();
                this.mainActividadView.undelegateEvents();
            }

            this.mainActividadView = new app.MainActividadView( );
        },

        getActividadesCreate: function () {
            this.actividadModel = new app.ActividadModel();

            if ( this.createActividadView instanceof Backbone.View ){
                this.createActividadView.stopListening();
                this.createActividadView.undelegateEvents();
            }

            this.createActividadView = new app.CreateActividadView({ model: this.actividadModel });
            this.createActividadView.render();
        },

        getActividadesEdit: function (actividad) {
            this.actividadModel = new app.ActividadModel();
            this.actividadModel.set({'id': actividad}, {silent: true});

            if ( this.createActividadView instanceof Backbone.View ){
                this.createActividadView.stopListening();
                this.createActividadView.undelegateEvents();
            }

            this.createActividadView = new app.CreateActividadView({ model: this.actividadModel });
            this.actividadModel.fetch();
        },

        // Sucursales
        getSucursalesMain: function () {

            if ( this.mainSucursalesView instanceof Backbone.View ){
                this.mainSucursalesView.stopListening();
                this.mainSucursalesView.undelegateEvents();
            }

            this.mainSucursalesView = new app.MainSucursalesView( );
        },

        getSucursalesCreate: function () {
            this.sucursalModel = new app.SucursalModel();

            if ( this.createSucursalView instanceof Backbone.View ){
                this.createSucursalView.stopListening();
                this.createSucursalView.undelegateEvents();
            }

            this.createSucursalView = new app.CreateSucursalView({ model: this.sucursalModel });
            this.createSucursalView.render();
        },

        getSucursalesEdit: function (sucursal) {
            this.sucursalModel = new app.SucursalModel();
            this.sucursalModel.set({'id': sucursal}, {silent: true});

            if ( this.createSucursalView instanceof Backbone.View ){
                this.createSucursalView.stopListening();
                this.createSucursalView.undelegateEvents();
            }

            this.createSucursalView = new app.CreateSucursalView({ model: this.sucursalModel });
            this.sucursalModel.fetch();
        },
        // Ubicaciones
        getUbicacionesMain: function () {

            if ( this.mainUbicacionesView instanceof Backbone.View ){
                this.mainUbicacionesView.stopListening();
                this.mainUbicacionesView.undelegateEvents();
            }
            this.mainUbicacionesView = new app.MainUbicacionesView( );
        },

        getUbicacionCreate: function () {
            this.ubicacionModel = new app.UbicacionModel();

            if ( this.createUbicacionView instanceof Backbone.View ){
                this.createUbicacionView.stopListening();
                this.createUbicacionView.undelegateEvents();
            }
            this.createUbicacionView = new app.CreateUbicacionView({ model: this.ubicacionModel });
            this.createUbicacionView.render();
        },

        getUbicacionEdit: function (ubicacion) {
            this.ubicacionModel = new app.UbicacionModel();
            this.ubicacionModel.set({'id': ubicacion}, {silent: true});

            if ( this.createUbicacionView instanceof Backbone.View ){
                this.createUbicacionView.stopListening();
                this.createUbicacionView.undelegateEvents();
            }
            this.createUbicacionView = new app.CreateUbicacionView({ model: this.ubicacionModel });
            this.ubicacionModel.fetch();
        },
        //Regionales
        getRegionalesMain:function(){
            if ( this.mainRegionalesView instanceof Backbone.View ){
                this.mainRegionalesView.stopListening();
                this.mainRegionalesView.undelegateEvents();
            }

            this.mainRegionalesView = new app.MainRegionalesView( );
        },

        getRegionalesCreate: function () {
            this.regionalModel = new app.RegionalModel();

            if ( this.createRegionalView instanceof Backbone.View ){
                this.createRegionalView.stopListening();
                this.createRegionalView.undelegateEvents();
            }

            this.createRegionalView = new app.CreateRegionalView({ model: this.regionalModel });
            this.createRegionalView.render();
        },

        getRegionalesEdit: function (regional) {
            this.regionalModel = new app.RegionalModel();
            this.regionalModel.set({'id': regional}, {silent: true});

            if ( this.createRegionalView instanceof Backbone.View ){
                this.createRegionalView.stopListening();
                this.createRegionalView.undelegateEvents();
            }

            this.createRegionalView = new app.CreateRegionalView({ model: this.regionalModel });
            this.regionalModel.fetch();
        },

        // Vistas de Departamentos
        getDepartamentosMain: function () {

            if ( this.mainDepartamentoView instanceof Backbone.View ){
                this.mainDepartamentoView.stopListening();
                this.mainDepartamentoView.undelegateEvents();
            }

            this.mainDepartamentoView = new app.MainDepartamentoView( );
        },

        //Documento
        getDocumentoMain: function () {
            if ( this.mainDocumentoView instanceof Backbone.View ){
                this.mainDocumentoView.stopListening();
                this.mainDocumentoView.undelegateEvents();
            }

            this.mainDocumentoView = new app.MainDocumentoView( );
        },

        getDocumentoCreate: function () {
            this.documentosModel = new app.DocumentosModel();

            if ( this.createDocumentosView instanceof Backbone.View ){
                this.createDocumentosView.stopListening();
                this.createDocumentosView.undelegateEvents();
            }

            this.createDocumentosView = new app.CreateDocumentosView({ model: this.documentosModel });
            this.createDocumentosView.render();
        },

        getDocumentoEdit: function (documento) {
            this.documentosModel = new app.DocumentosModel();
            this.documentosModel.set({'id': documento}, {silent: true});

            if ( this.createDocumentosView instanceof Backbone.View ){
                this.createDocumentosView.stopListening();
                this.createDocumentosView.undelegateEvents();
            }

            this.createDocumentosView = new app.CreateDocumentosView({ model: this.documentosModel });
            this.documentosModel.fetch();
        },

        // Vistas de Municipios
        getMunicipiosMain: function () {

            if ( this.mainMunicipioView instanceof Backbone.View ){
                this.mainMunicipioView.stopListening();
                this.mainMunicipioView.undelegateEvents();
            }

            this.mainMunicipioView = new app.MainMunicipioView( );
        },
        // Vistas de Paises
        getPaisesMain: function () {

            if ( this.mainPaisesView instanceof Backbone.View ){
                this.mainPaisesView.stopListening();
                this.mainPaisesView.undelegateEvents();
            }
            this.mainPaisesView = new app.MainPaisesView( );
        },

        // Puntos de Venta
        getPuntosVentaMain: function () {

            if ( this.mainPuntoventaView instanceof Backbone.View ){
                this.mainPuntoventaView.stopListening();
                this.mainPuntoventaView.undelegateEvents();
            }

            this.mainPuntoventaView = new app.MainPuntoventaView( );
        },

        /**
        * show view create puntos de venta
        */
        getPuntosVentaCreate: function () {
            this.puntoVentaModel = new app.PuntoVentaModel();

            if ( this.createPuntoventaView instanceof Backbone.View ){
                this.createPuntoventaView.stopListening();
                this.createPuntoventaView.undelegateEvents();
            }

            this.createPuntoventaView = new app.CreatePuntoventaView({ model: this.puntoVentaModel });
            this.createPuntoventaView.render();
        },

        /**
        * show view edit puntos de venta
        */
        getPuntosVentaEdit: function (puntoventa) {
            this.puntoVentaModel = new app.PuntoVentaModel();
            this.puntoVentaModel.set({'id': puntoventa}, {silent: true});

            if ( this.createPuntoventaView instanceof Backbone.View ){
                this.createPuntoventaView.stopListening();
                this.createPuntoventaView.undelegateEvents();
            }

            this.createPuntoventaView = new app.CreatePuntoventaView({ model: this.puntoVentaModel });
            this.puntoVentaModel.fetch();
        },

        // Tipos Actividad
        getTiposActividadMain: function () {

            if ( this.mainTipoActividadView instanceof Backbone.View ){
                this.mainTipoActividadView.stopListening();
                this.mainTipoActividadView.undelegateEvents();
            }

            this.mainTipoActividadView = new app.MainTipoActividadView( );
        },

        /**
        * show view create tipos actividad
        */
        getTiposActividadCreate: function () {
            this.tipoActividadModel = new app.TipoActividadModel();

            if ( this.createTipoactividadView instanceof Backbone.View ){
                this.createTipoactividadView.stopListening();
                this.createTipoactividadView.undelegateEvents();
            }

            this.createTipoactividadView = new app.CreateTipoActividadView({ model: this.tipoActividadModel });
            this.createTipoactividadView.render();
        },

        /**
        * show view edit tipos actividad
        */
        getTiposActividadEdit: function (tipoactividad) {
            this.tipoActividadModel = new app.TipoActividadModel();
            this.tipoActividadModel.set({'id': tipoactividad}, {silent: true});

            if ( this.createTipoActividadView instanceof Backbone.View ){
                this.createTipoActividadView.stopListening();
                this.createTipoActividadView.undelegateEvents();
            }

            this.createTipoActividadView = new app.CreateTipoActividadView({ model: this.tipoActividadModel });
            this.tipoActividadModel.fetch();
        },
        // Tipos Ajuste
        getTiposAjusteMain: function () {

            if ( this.mainTipoAjusteView instanceof Backbone.View ){
                this.mainTipoAjusteView.stopListening();
                this.mainTipoAjusteView.undelegateEvents();
            }

            this.mainTipoAjusteView = new app.MainTipoAjusteView( );
        },

        /**
        * show view create tipos ajuste
        */
        getTipoAjusteCreate: function () {
            this.tipoAjusteModel = new app.TipoAjusteModel();

            if ( this.createTipoajusteView instanceof Backbone.View ){
                this.createTipoajusteView.stopListening();
                this.createTipoajusteView.undelegateEvents();
            }

            this.createTipoajusteView = new app.CreateTipoAjusteView({ model: this.tipoAjusteModel });
            this.createTipoajusteView.render();
        },

        /**
        * show view edit tipos ajuste
        */
        getTipoAjusteEdit: function (tipoajuste) {
            this.tipoAjusteModel = new app.TipoAjusteModel();
            this.tipoAjusteModel.set({'id': tipoajuste}, {silent: true});

            if ( this.createTipoAjusteView instanceof Backbone.View ){
                this.createTipoAjusteView.stopListening();
                this.createTipoAjusteView.undelegateEvents();
            }

            this.createTipoAjusteView = new app.CreateTipoAjusteView({ model: this.tipoAjusteModel });
            this.tipoAjusteModel.fetch();
        },

        //Tipos Traslados
        getTiposTrasladosMain: function () {

            if ( this.mainTipoTrasladosView instanceof Backbone.View ){
                this.mainTipoTrasladosView.stopListening();
                this.mainTipoTrasladosView.undelegateEvents();
            }

            this.mainTipoTrasladosView = new app.MainTipoTrasladosView( );
        },

        /**
        * show view create tipos traslado
        */
        getTipoTrasladoCreate: function () {
            this.tipoTrasladoModel = new app.TipoTrasladoModel();

            if ( this.createTipoTrasladoView instanceof Backbone.View ){
                this.createTipoTrasladoView.stopListening();
                this.createTipoTrasladoView.undelegateEvents();
            }

            this.createTipoTrasladoView = new app.CreateTipoTrasladoView({ model: this.tipoTrasladoModel });
            this.createTipoTrasladoView.render();
        },

        /**
        * show view edit tipos traslado
        */
        getTipoTrasladoEdit: function (tipotraslado) {
            this.tipoTrasladoModel = new app.TipoTrasladoModel();
            this.tipoTrasladoModel.set({'id': tipotraslado}, {silent: true});

            if ( this.createTipoTrasladoView instanceof Backbone.View ){
                this.createTipoTrasladoView.stopListening();
                this.createTipoTrasladoView.undelegateEvents();
            }

            this.createTipoTrasladoView = new app.CreateTipoTrasladoView({ model: this.tipoTrasladoModel });
            this.tipoTrasladoModel.fetch();
        },

        /*
        |-----------------------
        | Comercial
        |-----------------------
        */
        getPresupuestoAsesorMain: function () {
            if ( this.mainPresupuestoAsesorView instanceof Backbone.View ){
                this.mainPresupuestoAsesorView.stopListening();
                this.mainPresupuestoAsesorView.undelegateEvents();
            }

            this.mainPresupuestoAsesorView = new app.MainPresupuestoAsesorView( );
        },

        getConceptosComMain: function () {

            if ( this.mainConceptoComView instanceof Backbone.View ){
                this.mainConceptoComView.stopListening();
                this.mainConceptoComView.undelegateEvents();
            }

            this.mainConceptoComView = new app.MainConceptosComView( );
        },

        getConceptoComCreate: function () {
            this.conceptoComModel = new app.ConceptoComModel();

            if ( this.createConceptoComView instanceof Backbone.View ){
                this.createConceptoComView.stopListening();
                this.createConceptoComView.undelegateEvents();
            }

            this.createConceptoComView = new app.CreateConceptoComView({ model: this.conceptoComModel });
            this.createConceptoComView.render();
        },

        getConceptoComEdit: function (conceptoscomercial) {
            this.conceptoComModel = new app.ConceptoComModel();
            this.conceptoComModel.set({'id': conceptoscomercial}, {'silent':true});

            if ( this.createConceptoComView instanceof Backbone.View ){
                this.createConceptoComView.stopListening();
                this.createConceptoComView.undelegateEvents();
            }

            this.createConceptoComView = new app.CreateConceptoComView({ model: this.conceptoComModel });
            this.conceptoComModel.fetch();
        },

        getGestionesComercialMain: function(){

            if (this.mainGestionesComercialView instanceof Backbone.View) {
                this.mainGestionesComercialView.stopListening();
                this.mainGestionesComercialView.undelegateEvents();
            }
            this.mainGestionesComercialView = new app.MainGestionesComercialView( );
        },
        getGestionComercialCreate: function(){
            this.gestionComercialModel = new app.GestionComercialModel();

            if (this.createGestionComercialView instanceof Backbone.View) {
                this.createGestionComercialView.stopListening();
                this.createGestionComercialView.undelegateEvents();
            }
            this.createGestionComercialView = new app.CreateGestionComercialView({ model: this.gestionComercialModel });
            this.createGestionComercialView.render();
        },

        /*
        |-----------------------
        | Contabilidad
        |-----------------------
        */

        getFoldersMain: function () {

            if ( this.mainFoldersView instanceof Backbone.View ){
                this.mainFoldersView.stopListening();
                this.mainFoldersView.undelegateEvents();
            }

            this.mainFoldersView = new app.MainFoldersView( );
        },

        getFoldersCreate: function () {
            this.folderModel = new app.FolderModel();

            if ( this.createFolderView instanceof Backbone.View ){
                this.createFolderView.stopListening();
                this.createFolderView.undelegateEvents();
            }

            this.createFolderView = new app.CreateFolderView({ model: this.folderModel });
            this.createFolderView.render();
        },

        getFoldersEdit: function (folder) {
            this.folderModel = new app.FolderModel();
            this.folderModel.set({'id': folder}, {silent: true});

            if ( this.createFolderView instanceof Backbone.View ){
                this.createFolderView.stopListening();
                this.createFolderView.undelegateEvents();
            }

            this.createFolderView = new app.CreateFolderView({ model: this.folderModel });
            this.folderModel.fetch();
        },

        //Documento
        getDocumentosMain: function () {
            if ( this.mainDocumentosView instanceof Backbone.View ){
                this.mainDocumentosView.stopListening();
                this.mainDocumentosView.undelegateEvents();
            }

            this.mainDocumentosView = new app.MainDocumentosView( );
        },

        getDocumentosCreate: function () {
            this.documentoModel = new app.DocumentoModel();

            if ( this.createDocumentoView instanceof Backbone.View ){
                this.createDocumentoView.stopListening();
                this.createDocumentoView.undelegateEvents();
            }

            this.createDocumentoView = new app.CreateDocumentoView({ model: this.documentoModel });
            this.createDocumentoView.render();
        },

        getDocumentosEdit: function (documento) {
            this.documentoModel = new app.DocumentoModel();
            this.documentoModel.set({'id': documento}, {silent: true});

            if ( this.createDocumentoView instanceof Backbone.View ){
                this.createDocumentoView.stopListening();
                this.createDocumentoView.undelegateEvents();
            }

            this.createDocumentoView = new app.CreateDocumentoView({ model: this.documentoModel });
            this.documentoModel.fetch();
        },

        // Plan cuentas
        getPlanCuentasMain: function () {

            if ( this.mainPlanCuentasView instanceof Backbone.View ){
                this.mainPlanCuentasView.stopListening();
                this.mainPlanCuentasView.undelegateEvents();
            }

            this.mainPlanCuentasView = new app.MainPlanCuentasView( );
        },

        getPlanCuentasCreate: function () {
            this.planCuentaModel = new app.PlanCuentaModel();

            if ( this.createPlanCuentaView instanceof Backbone.View ){
                this.createPlanCuentaView.stopListening();
                this.createPlanCuentaView.undelegateEvents();
            }

            this.createPlanCuentaView = new app.CreatePlanCuentaView({ model: this.planCuentaModel });
            this.createPlanCuentaView.render();
        },

        getPlanCuentasEdit: function (plancuenta) {
            this.planCuentaModel = new app.PlanCuentaModel();
            this.planCuentaModel.set({'id': plancuenta}, {silent: true});

            if ( this.createPlanCuentaView instanceof Backbone.View ){
                this.createPlanCuentaView.stopListening();
                this.createPlanCuentaView.undelegateEvents();
            }

            this.createPlanCuentaView = new app.CreatePlanCuentaView({ model: this.planCuentaModel });
            this.planCuentaModel.fetch();
        },

        // Centro de Costos
        getCentrosCostoMain: function () {

            if ( this.mainCentrosCostoView instanceof Backbone.View ){
                this.mainCentrosCostoView.stopListening();
                this.mainCentrosCostoView.undelegateEvents();
            }

            this.mainCentrosCostoView = new app.MainCentrosCostoView( );
        },

        getCentrosCostoCreate: function () {
            this.centroCostoModel = new app.CentroCostoModel();

            if ( this.createCentroCostoView instanceof Backbone.View ){
                this.createCentroCostoView.stopListening();
                this.createCentroCostoView.undelegateEvents();
            }

            this.createCentroCostoView = new app.CreateCentroCostoView({ model: this.centroCostoModel, parameters: { callback: 'toShow' } });
            this.createCentroCostoView.render();
        },

        getCentrosCostoEdit: function (centrocosto) {
            this.centroCostoModel = new app.CentroCostoModel();
            this.centroCostoModel.set({'id': centrocosto}, {silent: true});

            if ( this.createCentroCostoView instanceof Backbone.View ){
                this.createCentroCostoView.stopListening();
                this.createCentroCostoView.undelegateEvents();
            }

            this.createCentroCostoView = new app.CreateCentroCostoView({ model: this.centroCostoModel, parameters: { callback: 'toShow' } });
            this.centroCostoModel.fetch();
        },

        // Asientos
         getAsientosMain: function () {

            if ( this.mainAsientosView instanceof Backbone.View ){
                this.mainAsientosView.stopListening();
                this.mainAsientosView.undelegateEvents();
            }

            this.mainAsientosView = new app.MainAsientosView( );
        },

        getAsientosCreate: function () {
            this.asientoModel = new app.AsientoModel();

            if ( this.createAsientoView instanceof Backbone.View ){
                this.createAsientoView.stopListening();
                this.createAsientoView.undelegateEvents();
            }

            this.createAsientoView = new app.CreateAsientoView({ model: this.asientoModel });
            this.createAsientoView.render();
        },

        getAsientosShow: function (asiento) {
            this.asientoModel = new app.AsientoModel();
            this.asientoModel.set({'id': asiento}, {'silent':true});

            if ( this.showAsientoView instanceof Backbone.View ){
                this.showAsientoView.stopListening();
                this.showAsientoView.undelegateEvents();
            }

            this.showAsientoView = new app.ShowAsientoView({ model: this.asientoModel });
        },

        getAsientosEdit: function (asiento) {
            this.asientoModel = new app.AsientoModel();
            this.asientoModel.set({'id': asiento}, {'silent':true});

            if ( this.editAsientoView instanceof Backbone.View ){
                this.editAsientoView.stopListening();
                this.editAsientoView.undelegateEvents();
            }

            if ( this.createAsientoView instanceof Backbone.View ){
                this.createAsientoView.stopListening();
                this.createAsientoView.undelegateEvents();
            }

            this.editAsientoView = new app.EditAsientoView({ model: this.asientoModel });
            this.asientoModel.fetch();
        },

        // Inventario

        // Marca
        getMarcasMain: function () {

            if ( this.mainMarcaView instanceof Backbone.View ){
                this.mainMarcaView.stopListening();
                this.mainMarcaView.undelegateEvents();
            }

            this.mainMarcaView = new app.MainMarcasView( );
        },

        getMarcasCreate: function () {
            this.marcaModel = new app.MarcaModel();

            if ( this.createMarcaView instanceof Backbone.View ){
                this.createMarcaView.stopListening();
                this.createMarcaView.undelegateEvents();
            }

            this.createMarcaView = new app.CreateMarcaView({ model: this.marcaModel });
            this.createMarcaView.render();
        },

        getMarcasEdit: function (marcas) {
            this.marcaModel = new app.MarcaModel();
            this.marcaModel.set({'id': marcas}, {'silent':true});

            if ( this.createMarcaView instanceof Backbone.View ){
                this.createMarcaView.stopListening();
                this.createMarcaView.undelegateEvents();
            }

            this.createMarcaView = new app.CreateMarcaView({ model: this.marcaModel });
            this.marcaModel.fetch();
        },

        getCategoriasMain: function () {

            if ( this.mainCategoriasView instanceof Backbone.View ){
                this.mainCategoriasView.stopListening();
                this.mainCategoriasView.undelegateEvents();
            }

            this.mainCategoriasView = new app.MainCategoriasView( );
        },

        getCategoriasCreate: function () {
            this.categoriaModel = new app.CategoriaModel();

            if ( this.createCategoriaView instanceof Backbone.View ){
                this.createCategoriaView.stopListening();
                this.createCategoriaView.undelegateEvents();
            }

            this.createCategoriaView = new app.CreateCategoriaView({ model: this.categoriaModel });
            this.createCategoriaView.render();
        },

        getCategoriasEdit: function (categorias) {
            this.categoriaModel = new app.CategoriaModel();
            this.categoriaModel.set({'id': categorias}, {'silent':true});

            if ( this.createCategoriaView instanceof Backbone.View ){
                this.createCategoriaView.stopListening();
                this.createCategoriaView.undelegateEvents();
            }

            this.createCategoriaView = new app.CreateCategoriaView({ model: this.categoriaModel });
            this.categoriaModel.fetch();
        },
        getSubCategoriasMain: function () {

            if ( this.mainSubCategoriasView instanceof Backbone.View ){
                this.mainSubCategoriasView.stopListening();
                this.mainSubCategoriasView.undelegateEvents();
            }

            this.mainSubCategoriasView = new app.MainSubCategoriasView( );
        },

        getSubCategoriasCreate: function () {
            this.subcategoriaModel = new app.SubCategoriaModel();

            if ( this.createSubCategoriaView instanceof Backbone.View ){
                this.createSubCategoriaView.stopListening();
                this.createSubCategoriaView.undelegateEvents();
            }

            this.createCategoriaView = new app.CreateSubCategoriaView({ model: this.subcategoriaModel });
            this.createCategoriaView.render();
        },

        getSubCategoriasEdit: function (subcategorias) {
            this.subcategoriaModel = new app.SubCategoriaModel();
            this.subcategoriaModel.set({'id': subcategorias}, {'silent':true});

            if ( this.createSubCategoriaView instanceof Backbone.View ){
                this.createSubCategoriaView.stopListening();
                this.createSubCategoriaView.undelegateEvents();
            }

            this.createSubCategoriaView = new app.CreateSubCategoriaView({ model: this.subcategoriaModel });
            this.subcategoriaModel.fetch();
        },

        getImpuestosMain: function () {

            if ( this.mainImpuestosView instanceof Backbone.View ){
                this.mainImpuestosView.stopListening();
                this.mainImpuestosView.undelegateEvents();
            }

            this.mainImpuestosView = new app.MainImpuestosView( );
        },

        getImpuestoCreate: function () {
            this.impuestoModel = new app.ImpuestoModel();

            if ( this.createImpuestoView instanceof Backbone.View ){
                this.createImpuestoView.stopListening();
                this.createImpuestoView.undelegateEvents();
            }

            this.createImpuestoView = new app.CreateImpuestoView({ model: this.impuestoModel });
            this.createImpuestoView.render();
        },

        getImpuestoEdit: function (impuestos) {
            this.impuestoModel = new app.ImpuestoModel();
            this.impuestoModel.set({'id': impuestos}, {'silent':true});

            if ( this.createImpuestoView instanceof Backbone.View ){
                this.createImpuestoView.stopListening();
                this.createImpuestoView.undelegateEvents();
            }

            this.createImpuestoView = new app.CreateImpuestoView({ model: this.impuestoModel });
            this.impuestoModel.fetch();
        },

        getModelosMain: function () {

            if ( this.mainModeloView instanceof Backbone.View ){
                this.mainModeloView.stopListening();
                this.mainModeloView.undelegateEvents();
            }

            this.mainModeloView = new app.MainModelosView( );
        },

        getModelosCreate: function () {
            this.modeloModel = new app.ModeloModel();

            if ( this.createModeloView instanceof Backbone.View ){
                this.createModeloView.stopListening();
                this.createModeloView.undelegateEvents();
            }

            this.createModeloView = new app.CreateModeloView({ model: this.modeloModel });
            this.createModeloView.render();
        },

        getModelosEdit: function (modelos) {
            this.modeloModel = new app.ModeloModel();
            this.modeloModel.set({'id': modelos}, {'silent':true});

            if ( this.createModeloView instanceof Backbone.View ){
                this.createModeloView.stopListening();
                this.createModeloView.undelegateEvents();
            }

            this.createModeloView = new app.CreateModeloView({ model: this.modeloModel });
            this.modeloModel.fetch();
        },

        getLineasMain: function () {

            if ( this.mainLineasView instanceof Backbone.View ){
                this.mainLineasView.stopListening();
                this.mainLineasView.undelegateEvents();
            }

            this.mainLineasView = new app.MainLineasView( );
        },

        getLineaCreate: function () {
            this.lineaModel = new app.LineaModel();

            if ( this.createLineaView instanceof Backbone.View ){
                this.createLineaView.stopListening();
                this.createLineaView.undelegateEvents();
            }

            this.createLineaView = new app.CreateLineaView({ model: this.lineaModel });
            this.createLineaView.render();
        },

        getLineasEdit: function (lineas) {
            this.lineaModel = new app.LineaModel();
            this.lineaModel.set({'id': lineas}, {silent: true});

            if ( this.createLineaView instanceof Backbone.View ){
                this.createLineaView.stopListening();
                this.createLineaView.undelegateEvents();
            }

            this.createLineaView = new app.CreateLineaView({ model: this.lineaModel });
            this.lineaModel.fetch();
        },

        getUnidadesMain: function () {

            if ( this.mainUnidadesView instanceof Backbone.View ){
                this.mainUnidadesView.stopListening();
                this.mainUnidadesView.undelegateEvents();
            }

            this.mainUnidadesView = new app.MainUnidadesView( );
        },

        getUnidadesCreate: function () {
            this.unidadModel = new app.UnidadModel();

            if ( this.createUnidadView instanceof Backbone.View ){
                this.createUnidadView.stopListening();
                this.createUnidadView.undelegateEvents();
            }

            this.createUnidadView = new app.CreateUnidadView({ model: this.unidadModel });
            this.createUnidadView.render();
        },

        getUnidadesEdit: function (unidad) {
            this.unidadModel = new app.UnidadModel();
            this.unidadModel.set({'id': unidad}, {silent: true});

            if ( this.createUnidadView instanceof Backbone.View ){
                this.createUnidadView.stopListening();
                this.createUnidadView.undelegateEvents();
            }

            this.createUnidadView = new app.CreateUnidadView({ model: this.unidadModel });
            this.unidadModel.fetch();
        },

        getUnidadesNegocioMain: function () {

            if ( this.mainUnidadesNegocioView instanceof Backbone.View ){
                this.mainUnidadesNegocioView.stopListening();
                this.mainUnidadesNegocioView.undelegateEvents();
            }

            this.mainUnidadesNegocioView = new app.MainUnidadesNegocioView( );
        },

        getUnidadNegocioCreate: function () {
            this.unidadNegocioModel = new app.UnidadNegocioModel();

            if ( this.createUnidadNegocioView instanceof Backbone.View ){
                this.createUnidadNegocioView.stopListening();
                this.createUnidadNegocioView.undelegateEvents();
            }

            this.createUnidadNegocioView = new app.CreateUnidadNegocioView({ model: this.unidadNegocioModel });
            this.createUnidadNegocioView.render();
        },

        getUnidadNegocioEdit: function (unidadnegocio) {
            this.unidadNegocioModel = new app.UnidadNegocioModel();
            this.unidadNegocioModel.set({'id': unidadnegocio}, {silent: true});

            if ( this.createUnidadNegocioView instanceof Backbone.View ){
                this.createUnidadNegocioView.stopListening();
                this.createUnidadNegocioView.undelegateEvents();
            }

            this.createUnidadNegocioView = new app.CreateUnidadNegocioView({ model: this.unidadNegocioModel });
            this.unidadNegocioModel.fetch();
        },

        // Servicios
        getServiciosMain: function () {

            if ( this.mainServiciosView instanceof Backbone.View ){
                this.mainServiciosView.stopListening();
                this.mainServiciosView.undelegateEvents();
            }

            this.mainServiciosView = new app.MainServiciosView( );
        },

        getServiciosCreate: function () {
            this.servicioModel = new app.ServicioModel();

            if ( this.createServicioView instanceof Backbone.View ){
                this.createServicioView.stopListening();
                this.createServicioView.undelegateEvents();
            }

            this.createServicioView = new app.CreateServicioView({ model: this.servicioModel });
            this.createServicioView.render();
        },

        getServiciosEdit: function ( servicios ) {
            this.servicioModel = new app.ServicioModel();
            this.servicioModel.set({'id': servicios }, {'silent':true});

            if ( this.createServicioView instanceof Backbone.View ){
                this.createServicioView.stopListening();
                this.createServicioView.undelegateEvents();
            }

            this.createServicioView = new app.CreateServicioView({ model: this.servicioModel });
            this.servicioModel.fetch();
        },

        /**
        * show view main producto
        */
        getProductosMain: function () {

            if ( this.mainProductosView instanceof Backbone.View ){
                this.mainProductosView.stopListening();
                this.mainProductosView.undelegateEvents();
            }

            this.mainProductosView = new app.MainProductosView( );
        },

        /**
        * show view create producto
        */
        getProductosCreate: function () {
            this.productoModel = new app.ProductoModel();

            if ( this.createProductoView instanceof Backbone.View ){
                this.createProductoView.stopListening();
                this.createProductoView.undelegateEvents();
            }

            this.createProductoView = new app.CreateProductoView({ model: this.productoModel });
            this.createProductoView.render();
        },

        /**
        * show view edit producto
        */
        getProductosEdit: function (producto) {
            this.productoModel = new app.ProductoModel();
            this.productoModel.set({'id': producto}, {silent: true});

            if ( this.createProductoView instanceof Backbone.View ){
                this.createProductoView.stopListening();
                this.createProductoView.undelegateEvents();
            }

            this.createProductoView = new app.CreateProductoView({ model: this.productoModel });
            this.productoModel.fetch();
        },

        getProductosShow: function (producto) {
            this.productoModel = new app.ProductoModel();
            this.productoModel.set({'id': producto}, {'silent':true});

            if ( this.showProductoView instanceof Backbone.View ){
                this.showProductoView.stopListening();
                this.showProductoView.undelegateEvents();
            }

            this.showProductoView = new app.ShowProductoView({ model: this.productoModel });
        },

        /**
        * show view main pedido
        */
        getPedidosMain: function () {

            if ( this.mainPedidosView instanceof Backbone.View ){
                this.mainPedidosView.stopListening();
                this.mainPedidosView.undelegateEvents();
            }

            this.mainPedidosView = new app.MainPedidosView( );
        },

        /**
        * show view create pedido
        */
        getPedidosCreate: function () {

            this.pedidoModel = new app.PedidoModel();

            if ( this.createPedidoView instanceof Backbone.View ){
                this.createPedidoView.stopListening();
                this.createPedidoView.undelegateEvents();
            }

            this.createPedidoView = new app.CreatePedidoView({ model: this.pedidoModel });
            this.createPedidoView.render();
        },

        /**
        * show view show pedido
        */
        getPedidoShow: function (pedidos) {
            this.pedidoModel = new app.PedidoModel();
            this.pedidoModel.set({'id': pedidos}, {'silent':true});

            if ( this.showPedidoView instanceof Backbone.View ){
                this.showPedidoView.stopListening();
                this.showPedidoView.undelegateEvents();
            }

            this.showPedidoView = new app.ShowPedidoView({ model: this.pedidoModel });
            this.pedidoModel.fetch();
        },

        /**
        * show view edit pedido
        */
        getPedidosEdit: function (pedido) {

            this.pedidoModel = new app.PedidoModel();
            this.pedidoModel.set({'id': pedido}, {silent: true});

            if ( this.editPedidoView instanceof Backbone.View ){
                this.editPedidoView.stopListening();
                this.editPedidoView.undelegateEvents();
            }
            if ( this.createPedidoView instanceof Backbone.View ){
                this.createPedidoView.stopListening();
                this.createPedidoView.undelegateEvents();
            }

            this.editPedidoView = new app.EditPedidoView({ model: this.pedidoModel });
            this.pedidoModel.fetch();

        },

        /**
        * show view main ajuste
        */
        getAjustesMain:function(){

            if ( this.mainAjustesView instanceof Backbone.View ){
                this.mainAjustesView.stopListening();
                this.mainAjustesView.undelegateEvents();
            }

            this.mainAjustesView = new app.MainAjustesView();
        },
        /**
        * show view create ajuste
        */
        getAjustesCreate:function(){
            this.ajusteModel = new app.AjusteModel();

            if ( this.createAjusteView instanceof Backbone.View ){
                this.createAjusteView.stopListening();
                this.createAjusteView.undelegateEvents();
            }

            this.createAjusteView = new app.CreateAjusteView({ model: this.ajusteModel });
            this.createAjusteView.render();
        },

        /**
        * show view show ajustes
        */
        getAjusteShow: function (ajustes) {
            this.ajusteModel = new app.AjusteModel();
            this.ajusteModel.set({'id': ajustes}, {'silent':true});

            if ( this.showAjusteView instanceof Backbone.View ){
                this.showAjusteView.stopListening();
                this.showAjusteView.undelegateEvents();
            }

            this.showAjusteView = new app.ShowAjusteView({ model: this.ajusteModel });
            this.ajusteModel.fetch();
        },

        /**
        * show view main traslados
        */
        getTrasladosMain: function () {

            if ( this.mainTrasladosView instanceof Backbone.View ){
                this.mainTrasladosView.stopListening();
                this.mainTrasladosView.undelegateEvents();
            }

            this.mainTrasladosView = new app.MainTrasladosView( );
        },

        /**
        * show view create traslado
        */
        getTrasladosCreate: function () {
            this.trasladoModel = new app.TrasladoModel();

            if ( this.createTrasladoView instanceof Backbone.View ){
                this.createTrasladoView.stopListening();
                this.createTrasladoView.undelegateEvents();
            }

            this.createTrasladoView = new app.CreateTrasladoView({ model: this.trasladoModel });
            this.createTrasladoView.render();
        },

        /**
        * show view show traslado
        */
        getTrasladosShow: function (traslado) {
            this.trasladoModel = new app.TrasladoModel();
            this.trasladoModel.set({'id': traslado}, {'silent':true});

            if ( this.showTrasladoView instanceof Backbone.View ){
                this.showTrasladoView.stopListening();
                this.showTrasladoView.undelegateEvents();
            }

            this.showTrasladoView = new app.ShowTrasladoView({ model: this.trasladoModel });
        }, 
        /**
        * show view main traslados ubicaciones
        */
        getTrasladosUbicacionesMain: function () {

            if ( this.mainTrasladosUbicacionesView instanceof Backbone.View ){
                this.mainTrasladosUbicacionesView.stopListening();
                this.mainTrasladosUbicacionesView.undelegateEvents();
            }

            this.mainTrasladosUbicacionesView = new app.MainTrasladosUbicacionesView( );
        },

        /**
        * show view create traslado ubicacion
        */
        getTrasladoUbicacionCreate: function () {
            this.trasladoUbicacionModel = new app.TrasladoUbicacionModel();

            if ( this.createTrasladoUbicacionView instanceof Backbone.View ){
                this.createTrasladoUbicacionView.stopListening();
                this.createTrasladoUbicacionView.undelegateEvents();
            }

            this.createTrasladoUbicacionView = new app.CreateTrasladoUbicacionView({ model: this.trasladoUbicacionModel });
            this.createTrasladoUbicacionView.render();
        },

        /**
        * show view show traslado ubicacion
        */
        getTrasladoUbicacionShow: function (trasladoUbicacion) {
            this.trasladoUbicacionModel = new app.TrasladoUbicacionModel();
            this.trasladoUbicacionModel.set({'id': trasladoUbicacion}, {'silent':true});

            if ( this.showTrasladoUbicacionView instanceof Backbone.View ){
                this.showTrasladoUbicacionView.stopListening();
                this.showTrasladoUbicacionView.undelegateEvents();
            }

            this.showTrasladoUbicacionView = new app.ShowTrasladoUbicacionView({ model: this.trasladoUbicacionModel });
        },        

        /**
        * show view main Autorizaciones Cartera
        */
        getAutorizacionesCaMain: function () {

            if ( this.mainAutorizacionesCaView instanceof Backbone.View ){
                this.mainAutorizacionesCaView.stopListening();
                this.mainAutorizacionesCaView.undelegateEvents();
            }

            this.mainAutorizacionesCaView = new app.MainAutorizacionesCaView( );
        },

        /**
        *show view main pedidosc Cartera
        */
        getPedidoscMain: function(){

            if ( this.mainPedidoscView instanceof Backbone.View ){
                this.mainPedidoscView.stopListening();
                this.mainPedidoscView.undelegateEvents();
            }

            this.mainPedidoscView = new app.MainPedidoscView( );
        },
        /**
        *show view create pedidosc Cartera
        */
        getPedidoscCreate: function(){
            this.pedidoscModel = new app.PedidoscModel();

            if ( this.createPedidoscView instanceof Backbone.View ){
                this.createPedidoscView.stopListening();
                this.createPedidoscView.undelegateEvents();
            }

            this.createPedidoscView = new app.CreatePedidoscView({ model: this.pedidoscModel });
            this.createPedidoscView.render();
        },
        /**
        * show view show pedido comercial
        */
        getPedidoscShow: function (pedidosc) {
            this.pedidoscModel = new app.PedidoscModel();
            this.pedidoscModel.set({'id': pedidosc}, {'silent':true});

            if ( this.showPedidocView instanceof Backbone.View ){
                this.showPedidocView.stopListening();
                this.showPedidocView.undelegateEvents();
            }

            this.showPedidocView = new app.ShowPedidocView({ model: this.pedidoscModel });
        },
        /**
        * show main view permisos
        */
        getPermisosMain: function () {

            if ( this.mainPermisoView instanceof Backbone.View ){
                this.mainPermisoView.stopListening();
                this.mainPermisoView.undelegateEvents();
            }

            this.mainPermisoView = new app.MainPermisoView( );
        },

        /**
        * show main view modulos
        */
        getModulosMain: function () {

            if ( this.mainModuloView instanceof Backbone.View ){
                this.mainModuloView.stopListening();
                this.mainModuloView.undelegateEvents();
            }

            this.mainModuloView = new app.MainModuloView( );
        },

        /**
        * show view main roles
        */
        getRolesMain: function () {

            if ( this.mainRolesView instanceof Backbone.View ){
                this.mainRolesView.stopListening();
                this.mainRolesView.undelegateEvents();
            }

            this.mainRolesView = new app.MainRolesView( );
        },

        /**
        * show view create roles
        */
        getRolesCreate: function () {
            this.rolModel = new app.RolModel();

            if ( this.createRolView instanceof Backbone.View ){
                this.createRolView.stopListening();
                this.createRolView.undelegateEvents();
            }

            this.createRolView = new app.CreateRolView({ model: this.rolModel });
            this.createRolView.render();
        },

        /**
        * show view edit roles
        */
        getRolesEdit: function (rol) {
            this.rolModel = new app.RolModel();
            this.rolModel.set({'id': rol}, {silent: true});

            if ( this.createRolView instanceof Backbone.View ){
                this.createRolView.stopListening();
                this.createRolView.undelegateEvents();
            }

            this.createRolView = new app.CreateRolView({ model: this.rolModel });
            this.rolModel.fetch();
        },

        // Banco
        getBancosMain: function () {

            if ( this.mainBancoView instanceof Backbone.View ){
                this.mainBancoView.stopListening();
                this.mainBancoView.undelegateEvents();
            }

            this.mainBancoView = new app.MainBancosView( );
        },

        getBancosCreate: function () {
            this.bancoModel = new app.BancoModel();

            if ( this.createBancoView instanceof Backbone.View ){
                this.createBancoView.stopListening();
                this.createBancoView.undelegateEvents();
            }

            this.createBancoView = new app.CreateBancoView({ model: this.bancoModel });
            this.createBancoView.render();
        },

        getBancosEdit: function (bancos) {
            this.bancoModel = new app.BancoModel();
            this.bancoModel.set({'id': bancos}, {'silent':true});

            if ( this.createBancoView instanceof Backbone.View ){
                this.createBancoView.stopListening();
                this.createBancoView.undelegateEvents();
            }

            this.createBancoView = new app.CreateBancoView({ model: this.bancoModel });
            this.bancoModel.fetch();
        },
        // Causa
        getCausasMain: function () {

            if ( this.mainCausasView instanceof Backbone.View ){
                this.mainCausasView.stopListening();
                this.mainCausasView.undelegateEvents();
            }

            this.mainCausasView = new app.MainCausasView( );
        },

        getCausaCreate: function () {
            this.causaModel = new app.CausaModel();

            if ( this.createCausaView instanceof Backbone.View ){
                this.createCausaView.stopListening();
                this.createCausaView.undelegateEvents();
            }

            this.createCausaView = new app.CreateCausaView({ model: this.causaModel });
            this.createCausaView.render();
        },

        getCausaEdit: function (causas) {
            this.causaModel = new app.CausaModel();
            this.causaModel.set({'id': causas}, {'silent':true});

            if ( this.createCausaView instanceof Backbone.View ){
                this.createCausaView.stopListening();
                this.createCausaView.undelegateEvents();
            }

            this.createCausaView = new app.CreateCausaView({ model: this.causaModel });
            this.causaModel.fetch();
        },

        // Cuenta de banco
        getCuentaBancosMain: function () {

            if ( this.mainCuentaBancoView instanceof Backbone.View ){
                this.mainCuentaBancoView.stopListening();
                this.mainCuentaBancoView.undelegateEvents();
            }

            this.mainCuentaBancoView = new app.MainCuentaBancosView( );
        },

        getCuentaBancosCreate: function () {
            this.cuentabancoModel = new app.CuentaBancoModel();

            if ( this.createCuentaBancoView instanceof Backbone.View ){
                this.createCuentaBancoView.stopListening();
                this.createCuentaBancoView.undelegateEvents();
            }

            this.createCuentaBancoView = new app.CreateCuentaBancoView({ model: this.cuentabancoModel });
            this.createCuentaBancoView.render();
        },

        getCuentaBancosEdit: function (cuentabancos) {
            this.cuentabancoModel = new app.CuentaBancoModel();
            this.cuentabancoModel.set({'id': cuentabancos}, {'silent':true});

            if ( this.createCuentaBancoView instanceof Backbone.View ){
                this.createCuentaBancoView.stopListening();
                this.createCuentaBancoView.undelegateEvents();
            }

            this.createCuentaBancoView = new app.CreateCuentaBancoView({ model: this.cuentabancoModel });
            this.cuentabancoModel.fetch();
        },

        // Medio Pago
        getMedioPagosMain: function () {

            if ( this.mainMedioPagoView instanceof Backbone.View ){
                this.mainMedioPagoView.stopListening();
                this.mainMedioPagoView.undelegateEvents();
            }

            this.mainMedioPagoView = new app.MainMedioPagosView( );
        },

        getMedioPagosCreate: function () {
            this.mediopagoModel = new app.MedioPagoModel();

            if ( this.createMedioPagoView instanceof Backbone.View ){
                this.createMedioPagoView.stopListening();
                this.createMedioPagoView.undelegateEvents();
            }

            this.createMedioPagoView = new app.CreateMedioPagoView({ model: this.mediopagoModel });
            this.createMedioPagoView.render();
        },

        getMedioPagosEdit: function (mediopagos) {
            this.mediopagoModel = new app.MedioPagoModel();
            this.mediopagoModel.set({'id': mediopagos}, {'silent':true});

            if ( this.createMedioPagoView instanceof Backbone.View ){
                this.createMedioPagoView.stopListening();
                this.createMedioPagoView.undelegateEvents();
            }

            this.createMedioPagoView = new app.CreateMedioPagoView({ model: this.mediopagoModel });
            this.mediopagoModel.fetch();
        },
        // Concepto Cobro
        getConceptosCobMain: function () {

            if ( this.mainConceptoCobView instanceof Backbone.View ){
                this.mainConceptoCobView.stopListening();
                this.mainConceptoCobView.undelegateEvents();
            }

            this.mainConceptoCobView = new app.MainConceptosCobView( );
        },

        getConceptoCobCreate: function () {
            this.conceptoCobModel = new app.ConceptoCobModel();

            if ( this.createConceptoCobView instanceof Backbone.View ){
                this.createConceptoCobView.stopListening();
                this.createConceptoCobView.undelegateEvents();
            }

            this.createConceptoCobView = new app.CreateConceptoCobView({ model: this.conceptoCobModel });
            this.createConceptoCobView.render();
        },

        getConceptoCobEdit: function (conceptocobros) {
            this.conceptoCobModel = new app.ConceptoCobModel();
            this.conceptoCobModel.set({'id': conceptocobros}, {'silent':true});

            if ( this.createConceptoCobView instanceof Backbone.View ){
                this.createConceptoCobView.stopListening();
                this.createConceptoCobView.undelegateEvents();
            }

            this.createConceptoCobView = new app.CreateConceptoCobView({ model: this.conceptoCobModel });
            this.conceptoCobModel.fetch();
        },
        // Conceptosrc
        getConceptosrcMain: function () {

            if ( this.mainConceptosrcView instanceof Backbone.View ){
                this.mainConceptosrcView.stopListening();
                this.mainConceptosrcView.undelegateEvents();
            }

            this.mainConceptosrcView = new app.MainConceptosrcView( );
        },

        getConceptosrcCreate: function () {
            this.conceptosrcModel = new app.ConceptosrcModel();

            if ( this.createConceptosrcView instanceof Backbone.View ){
                this.createConceptosrcView.stopListening();
                this.createConceptosrcView.undelegateEvents();
            }

            this.createConceptosrcView = new app.CreateConceptosrcView({ model: this.conceptosrcModel });
            this.createConceptosrcView.render();
        },

        getConceptosrcEdit: function (conceptosrc) {
            this.conceptosrcModel = new app.ConceptosrcModel();
            this.conceptosrcModel.set({'id': conceptosrc}, {'silent':true});

            if ( this.createConceptosrcView instanceof Backbone.View ){
                this.createConceptosrcView.stopListening();
                this.createConceptosrcView.undelegateEvents();
            }

            this.createConceptosrcView = new app.CreateConceptosrcView({ model: this.conceptosrcModel });
            this.conceptosrcModel.fetch();
        },

        // Facturas
        getFacturasMain: function () {

            if ( this.mainFacturaView instanceof Backbone.View ){
                this.mainFacturaView.stopListening();
                this.mainFacturaView.undelegateEvents();
            }

            this.mainFacturaView = new app.MainFacturasView( );
        },

        getFacturaCreate: function () {
            this.facturaModel = new app.FacturaModel();
            if ( this.createFacturaView instanceof Backbone.View ){
                this.createFacturaView.stopListening();
                this.createFacturaView.undelegateEvents();
            }

            this.createFacturaView = new app.CreateFacturaView({ model: this.facturaModel });
            this.createFacturaView.render();
        },
        getFacturaShow:function(facturas){
            this.facturaModel = new app.FacturaModel();
            this.facturaModel.set({'id': facturas}, {'silent':true});
            if ( this.showFacturasView instanceof Backbone.View ){
                this.showFacturasView.stopListening();
                this.showFacturasView.undelegateEvents();
            }

            this.showFacturasView = new app.ShowFacturaView({ model: this.facturaModel });
        },
        // Recibos
        getRecibosMain: function () {

            if ( this.mainReciboView instanceof Backbone.View ){
                this.mainReciboView.stopListening();
                this.mainReciboView.undelegateEvents();
            }

            this.mainReciboView = new app.MainRecibosView( );
        },

        getRecibosCreate: function () {
            this.reciboModel = new app.ReciboModel();

            if ( this.createReciboView instanceof Backbone.View ){
                this.createReciboView.stopListening();
                this.createReciboView.undelegateEvents();
            }

            this.createReciboView = new app.CreateReciboView({ model: this.reciboModel });
            this.createReciboView.render();
        },

        getRecibosShow: function (recibos) {
            this.reciboModel = new app.ReciboModel();
            this.reciboModel.set({'id': recibos}, {'silent':true});
            if ( this.showRecibosView instanceof Backbone.View ){
                this.showRecibosView.stopListening();
                this.showRecibosView.undelegateEvents();
            }

            this.showRecibosView = new app.ShowRecibosView({ model: this.reciboModel });
        },

        // Conceptonotas
        getConceptoNotasMain: function () {

            if ( this.mainConceptoNotaView instanceof Backbone.View ){
                this.mainConceptoNotaView.stopListening();
                this.mainConceptoNotaView.undelegateEvents();
            }

            this.mainConceptoNotaView = new app.MainConceptoNotaView( );
        },

        getConceptoNotasCreate: function () {
            this.conceptonotaModel = new app.ConceptoNotaModel();

            if ( this.createConceptoNotaView instanceof Backbone.View ){
                this.createConceptoNotaView.stopListening();
                this.createConceptoNotaView.undelegateEvents();
            }

            this.createConceptoNotaView = new app.CreateConceptoNotaView({ model: this.conceptonotaModel });
            this.createConceptoNotaView.render();
        },

        getConceptoNotasEdit: function (conceptonotaModel) {
            this.conceptonotaModel = new app.ConceptoNotaModel();
            this.conceptonotaModel.set({'id': conceptonotaModel}, {'silent':true});

            if ( this.createConceptoNotaView instanceof Backbone.View ){
                this.createConceptoNotaView.stopListening();
                this.createConceptoNotaView.undelegateEvents();
            }

            this.createConceptoNotaView = new app.CreateConceptoNotaView({ model: this.conceptonotaModel });
            this.conceptonotaModel.fetch();
        },

        // Notas
        getNotasMain: function () {
            if ( this.mainNotaView instanceof Backbone.View ){
                this.mainNotaView.stopListening();
                this.mainNotaView.undelegateEvents();
            }

            this.mainNotaView = new app.MainNotaView();
        },

        getNotasCreate: function () {
            this.notaModel = new app.NotaModel();

            if ( this.createNotaView instanceof Backbone.View ){
                this.createNotaView.stopListening();
                this.createNotaView.undelegateEvents();
            }

            this.createNotaView = new app.CreateNotaView({ model: this.notaModel });
            this.createNotaView.render();
        },

        getNotasShow: function (notaModel) {
            this.notaModel = new app.NotaModel();
            this.notaModel.set({'id': notaModel}, {'silent':true});
            if ( this.showNotaView instanceof Backbone.View ){
                this.showNotaView.stopListening();
                this.showNotaView.undelegateEvents();
            }

            this.showNotaView = new app.ShowNotaView({ model: this.notaModel });
        },

        //ConceptoAjustec
        getConceptosAjustecMain: function () {

            if ( this.mainConceptoAjustecView instanceof Backbone.View ){
                this.mainConceptoAjustecView.stopListening();
                this.mainConceptoAjustecView.undelegateEvents();
            }

            this.mainConceptoAjustecView = new app.MainConceptoAjustecView( );
        },

        getConceptosAjustecCreate: function () {
            this.conceptoajustecModel = new app.ConceptoAjustecModel();

            if ( this.createConceptoAjustecView instanceof Backbone.View ){
                this.createConceptoAjustecView.stopListening();
                this.createConceptoAjustecView.undelegateEvents();
            }

            this.createConceptoAjustecView = new app.CreateConceptoAjustecView({ model: this.conceptoajustecModel });
            this.createConceptoAjustecView.render();
        },

        getConceptosAjustecEdit: function (conceptoajustecModel) {
            this.conceptoajustecModel = new app.ConceptoAjustecModel();
            this.conceptoajustecModel.set({'id': conceptoajustecModel}, {'silent':true});

            if ( this.createConceptoAjustecView instanceof Backbone.View ){
                this.createConceptoAjustecView.stopListening();
                this.createConceptoAjustecView.undelegateEvents();
            }

            this.createConceptoAjustecView = new app.CreateConceptoAjustecView({ model: this.conceptoajustecModel });
            this.conceptoajustecModel.fetch();
        },

        //Ajustec
        getAjustescMain: function () {
            if ( this.mainAjustecView instanceof Backbone.View ){
                this.mainAjustecView.stopListening();
                this.mainAjustecView.undelegateEvents();
            }
            this.mainAjustecView = new app.MainAjustecView();
        },

        getAjustescCreate: function () {
            this.ajustec1Model = new app.Ajustec1Model();

            if ( this.createAjustecView instanceof Backbone.View ){
                this.createAjustecView.stopListening();
                this.createAjustecView.undelegateEvents();
            }

            this.createAjustecView = new app.CreateAjustecView({ model: this.ajustec1Model });
            this.createAjustecView.render();
        },

        getAjustescShow: function (ajustec1Model) {
            this.ajustec1Model = new app.Ajustec1Model();
            this.ajustec1Model.set({'id': ajustec1Model}, {'silent':true});
            if ( this.showAjustecView instanceof Backbone.View ){
                this.showAjustecView.stopListening();
                this.showAjustecView.undelegateEvents();
            }

            this.showAjustecView = new app.ShowAjustecView({ model: this.ajustec1Model });
        },

        // Devolucion
        getDevolucionesMain: function(){

            if (this.mainDevolucionesView instanceof Backbone.View) {
                this.mainDevolucionesView.stopListening();
                this.mainDevolucionesView.undelegateEvents();
            }

            this.mainDevolucionesView = new app.MainDevolucionesView( );
        },

        getDevolucionesCreate: function(){
            this.devolucionModel = new app.DevolucionModel();

            if (this.createDevolucionView instanceof Backbone.View) {
                this.createDevolucionView.stopListening();
                this.createDevolucionView.undelegateEvents();
            }
            
            this.createDevolucionView = new app.CreateDevolucionView({ model: this.devolucionModel });
            this.createDevolucionView.render();
        },

        getDevolucionesShow:function(devoluciones){
            this.devolucionModel = new app.DevolucionModel();
            this.devolucionModel.set({'id': devoluciones}, {'silent':true});
            
            if ( this.showDevolucionView instanceof Backbone.View ){
                this.showDevolucionView.stopListening();
                this.showDevolucionView.undelegateEvents();
            }

            this.showDevolucionView = new app.ShowDevolucionView({ model: this.devolucionModel });
        },
        // Anticipo
        getAnticiposMain: function(){

            if (this.mainAnticiposView instanceof Backbone.View) {
                this.mainAnticiposView.stopListening();
                this.mainAnticiposView.undelegateEvents();
            }
            this.mainAnticiposView = new app.MainAnticiposView( );
        },
        getAnticipoCreate: function(){
            this.anticipoModel = new app.AnticipoModel();

            if (this.createAnticipoView instanceof Backbone.View) {
                this.createAnticipoView.stopListening();
                this.createAnticipoView.undelegateEvents();
            }
            this.createAnticipoView = new app.CreateAnticipoView({ model: this.anticipoModel });
            this.createAnticipoView.render();
        },
        getAnticiposShow: function(anticipos){
            this.anticipoModel = new app.AnticipoModel();
            this.anticipoModel.set({'id' : anticipos }, {'silent' : true });

            if ( this.showAnticipoView instanceof Backbone.View ){
                this.showAnticipoView.stopListening();
                this.showAnticipoView.undelegateEvents();
            }
            
            this.showAnticipoView = new app.ShowAnticiposView({ model: this.anticipoModel });
        },

        // Cheques posfechados
        getChequesMain: function (){

            if (this.mainChequesView instanceof Backbone.View) {
                this.mainChequesView.stopListening();
                this.mainChequesView.undelegateEvents();
            }
            this.mainChequesView = new app.MainChequesView( );
        },

        getChequeCreate: function (){

            this.chequeModel = new app.ChequeModel();

            if (this.createChequesView instanceof Backbone.View) {
                this.createChequesView.stopListening();
                this.createChequesView.undelegateEvents();
            }
            this.createChequesView = new app.CreateChequesView({ model: this.chequeModel });
            this.createChequesView.render();
        },

        getChequeShow: function(cheques){
            this.chequeModel = new app.ChequeModel();
            this.chequeModel.set({'id' : cheques }, {'silent' : true });

            if ( this.showChequeView instanceof Backbone.View ){
                this.showChequeView.stopListening();
                this.showChequeView.undelegateEvents();
            }
            
            this.showChequeView = new app.ShowChequeView({ model: this.chequeModel });
        },
        // Cheques Devueltos
        getChequesDevueltosMain: function(){
            if (this.mainChequesDevueltosView instanceof Backbone.View) {
                this.mainChequesDevueltosView.stopListening();
                this.mainChequesDevueltosView.undelegateEvents();
            }
            this.mainChequesDevueltosView = new app.MainChequesDevueltosView( );
        },
        // Gestion Cobro
        getGestionCobrosMain: function(){

            if (this.mainGestionCobrosView instanceof Backbone.View) {
                this.mainGestionCobrosView.stopListening();
                this.mainGestionCobrosView.undelegateEvents();
            }
            this.mainGestionCobrosView = new app.MainGestionCobrosView( );
        },
        getGestionCobroCreate: function(){
            this.gestionCobroModel = new app.GestionCobroModel();

            if (this.createGestionCobroView instanceof Backbone.View) {
                this.createGestionCobroView.stopListening();
                this.createGestionCobroView.undelegateEvents();
            }
            this.createGestionCobroView = new app.CreateGestionCobroView({ model: this.gestionCobroModel });
            this.createGestionCobroView.render();
        },
        
        /*---------------------
        | Tecnicos
        /*--------------------*/

        // Tipo de Orden
        getTiposOrdenMain: function () {

            if ( this.mainTipoOrdenView instanceof Backbone.View ){
                this.mainTipoOrdenView.stopListening();
                this.mainTipoOrdenView.undelegateEvents();
            }

            this.mainTipoOrdenView = new app.MainTiposOrdenView( );
        },

        getTiposOrdenCreate: function () {
            this.tipoordenModel = new app.TipoOrdenModel();

            if ( this.createTipoOrdenView instanceof Backbone.View ){
                this.createTipoOrdenView.stopListening();
                this.createTipoOrdenView.undelegateEvents();
            }

            this.createTipoOrdenView = new app.CreateTipoOrdenView({ model: this.tipoordenModel });
            this.createTipoOrdenView.render();
        },

        getTiposOrdenEdit: function (tiposorden) {
            this.tipoordenModel = new app.TipoOrdenModel();
            this.tipoordenModel.set({'id': tiposorden}, {'silent':true});

            if ( this.createTipoOrdenView instanceof Backbone.View ){
                this.createTipoOrdenView.stopListening();
                this.createTipoOrdenView.undelegateEvents();
            }

            this.createTipoOrdenView = new app.CreateTipoOrdenView({ model: this.tipoordenModel });
            this.tipoordenModel.fetch();
        },

        // Solicitante
        getSolicitantesMain: function () {

            if ( this.mainSolicitanteView instanceof Backbone.View ){
                this.mainSolicitanteView.stopListening();
                this.mainSolicitanteView.undelegateEvents();
            }

            this.mainSolicitanteView = new app.MainSolicitantesView( );
        },

        getSolicitantesCreate: function () {
            this.solicitanteModel = new app.SolicitanteModel();

            if ( this.createSolicitanteView instanceof Backbone.View ){
                this.createSolicitanteView.stopListening();
                this.createSolicitanteView.undelegateEvents();
            }

            this.createSolicitanteView = new app.CreateSolicitanteView({ model: this.solicitanteModel });
            this.createSolicitanteView.render();
        },

        getSolicitantesEdit: function (solicitantes) {
            this.solicitanteModel = new app.SolicitanteModel();
            this.solicitanteModel.set({'id': solicitantes}, {'silent':true});

            if ( this.createSolicitanteView instanceof Backbone.View ){
                this.createSolicitanteView.stopListening();
                this.createSolicitanteView.undelegateEvents();
            }

            this.createSolicitanteView = new app.CreateSolicitanteView({ model: this.solicitanteModel });
            this.solicitanteModel.fetch();
        },

        // Daños
        getDanosMain: function () {

            if ( this.mainDanoView instanceof Backbone.View ){
                this.mainDanoView.stopListening();
                this.mainDanoView.undelegateEvents();
            }

            this.mainDanoView = new app.MainDanosView( );
        },

        getDanosCreate: function () {
            this.danoModel = new app.DanoModel();

            if ( this.createDanoView instanceof Backbone.View ){
                this.createDanoView.stopListening();
                this.createDanoView.undelegateEvents();
            }

            this.createDanoView = new app.CreateDanoView({ model: this.danoModel });
            this.createDanoView.render();
        },

        getDanosEdit: function (danos) {
            this.danoModel = new app.DanoModel();
            this.danoModel.set({'id': danos}, {'silent':true});

            if ( this.createDanoView instanceof Backbone.View ){
                this.createDanoView.stopListening();
                this.createDanoView.undelegateEvents();
            }

            this.createDanoView = new app.CreateDanoView({ model: this.danoModel });
            this.danoModel.fetch();
        },

        // Prioridad
        getPrioridadesMain: function () {

            if ( this.mainPrioridadView instanceof Backbone.View ){
                this.mainPrioridadView.stopListening();
                this.mainPrioridadView.undelegateEvents();
            }

            this.mainPrioridadView = new app.MainPrioridadesView( );
        },

        getPrioridadesCreate: function () {
            this.prioridadModel = new app.PrioridadModel();

            if ( this.createPrioridadView instanceof Backbone.View ){
                this.createPrioridadView.stopListening();
                this.createPrioridadView.undelegateEvents();
            }

            this.createPrioridadView = new app.CreatePrioridadView({ model: this.prioridadModel });
            this.createPrioridadView.render();
        },

        getPrioridadesEdit: function (prioridades) {
            this.prioridadModel = new app.PrioridadModel();
            this.prioridadModel.set({'id': prioridades}, {'silent':true});

            if ( this.createPrioridadView instanceof Backbone.View ){
                this.createPrioridadView.stopListening();
                this.createPrioridadView.undelegateEvents();
            }

            this.createPrioridadView = new app.CreatePrioridadView({ model: this.prioridadModel });
            this.prioridadModel.fetch();
        },

        //Contratos
        getContratosMain: function(){
            if ( this.mainContratoView instanceof Backbone.View ){
                this.mainContratoView.stopListening();
                this.mainContratoView.undelegateEvents();
            }
            this.mainContratoView = new app.MainContratosView( );

        },

        /**
        * show view main ordenes
        */
        getOrdenesMain: function () {
            if ( this.mainOrdenesView instanceof Backbone.View ){
                this.mainOrdenesView.stopListening();
                this.mainOrdenesView.undelegateEvents();
            }

            this.mainOrdenesView = new app.MainOrdenesView( );
        },

        /**
        * show view create ordenes
        */
        getOrdenesCreate: function () {
            this.ordenModel = new app.OrdenModel();

            if ( this.createOrdenView instanceof Backbone.View ){
                this.createOrdenView.stopListening();
                this.createOrdenView.undelegateEvents();
            }

            this.createOrdenView = new app.CreateOrdenView({ model: this.ordenModel });
            this.createOrdenView.render();
        },

        /**
        * show view edit ordenes
        */
        getOrdenesEdit: function (orden) {
            this.ordenModel = new app.OrdenModel();
            this.ordenModel.set({'id': orden}, {'silent':true});

            if ( this.editOrdenView instanceof Backbone.View ){
                this.editOrdenView.stopListening();
                this.editOrdenView.undelegateEvents();
            }

            if ( this.createOrdenView instanceof Backbone.View ){
                this.createOrdenView.stopListening();
                this.createOrdenView.undelegateEvents();
            }

            this.editOrdenView = new app.EditOrdenView({ model: this.ordenModel });
            this.ordenModel.fetch();
        },

        /**
        * show view show tercero
        */
        getOrdenesShow: function (orden) {
            this.ordenModel = new app.OrdenModel();
            this.ordenModel.set({'id': orden}, {silent: true});

            if ( this.showOrdenView instanceof Backbone.View ){
                this.showOrdenView.stopListening();
                this.showOrdenView.undelegateEvents();
            }

            this.showOrdenView = new app.ShowOrdenView({ model: this.ordenModel });
        },
        getConceptosTecMain: function () {

            if ( this.mainConceptoTecView instanceof Backbone.View ){
                this.mainConceptoTecView.stopListening();
                this.mainConceptoTecView.undelegateEvents();
            }

            this.mainConceptoTecView = new app.MainConceptosTecView( );
        },

        getConceptoTecCreate: function () {
            this.conceptoTecModel = new app.ConceptoTecModel();

            if ( this.createConceptoTecView instanceof Backbone.View ){
                this.createConceptoTecView.stopListening();
                this.createConceptoTecView.undelegateEvents();
            }

            this.createConceptoTecView = new app.CreateConceptoTecView({ model: this.conceptoTecModel });
            this.createConceptoTecView.render();
        },

        getConceptoTecEdit: function (conceptotecnico) {
            this.conceptoTecModel = new app.ConceptoTecModel();
            this.conceptoTecModel.set({'id': conceptotecnico}, {'silent':true});

            if ( this.createConceptoTecView instanceof Backbone.View ){
                this.createConceptoTecView.stopListening();
                this.createConceptoTecView.undelegateEvents();
            }

            this.createConceptoTecView = new app.CreateConceptoTecView({ model: this.conceptoTecModel });
            this.conceptoTecModel.fetch();
        },

        getGestionesTecnicoMain: function(){

            if (this.mainGestionesTecnicoView instanceof Backbone.View) {
                this.mainGestionesTecnicoView.stopListening();
                this.mainGestionesTecnicoView.undelegateEvents();
            }
            this.mainGestionesTecnicoView = new app.MainGestionesTecnicoView( );
        },
        getGestionTecnicoCreate: function(){
            this.gestionTecnicoModel = new app.GestionTecnicoModel();

            if (this.createGestionTecnicoView instanceof Backbone.View) {
                this.createGestionTecnicoView.stopListening();
                this.createGestionTecnicoView.undelegateEvents();
            }
            this.createGestionTecnicoView = new app.CreateGestionTecnicoView({ model: this.gestionTecnicoModel });
            this.createGestionTecnicoView.render();
        },

        // Sitios
        getSitiosMain: function () {

            if ( this.mainSitiosView instanceof Backbone.View ){
                this.mainSitiosView.stopListening();
                this.mainSitiosView.undelegateEvents();
            }

            this.mainSitiosView = new app.MainSitiosView( );
        },

        getSitiosCreate: function () {
            this.sitioModel = new app.SitioModel();

            if ( this.createSitioView instanceof Backbone.View ){
                this.createSitioView.stopListening();
                this.createSitioView.undelegateEvents();
            }

            this.createSitioView = new app.CreateSitioView({ model: this.sitioModel });
            this.createSitioView.render();
        },

        getSitiosEdit: function ( sitios ) {
            this.sitioModel = new app.SitioModel();
            this.sitioModel.set({'id': sitios}, {'silent':true});

            if ( this.createSitioView instanceof Backbone.View ){
                this.createSitioView.stopListening();
                this.createSitioView.undelegateEvents();
            }

            this.createSitioView = new app.CreateSitioView({ model: this.sitioModel });
            this.sitioModel.fetch();
        },

        getAgendaTecnicaMain: function () {
            if ( this.mainAgendaTecnicaView instanceof Backbone.View ){
                this.mainAgendaTecnicaView.stopListening();
                this.mainAgendaTecnicaView.undelegateEvents();
            }

            this.mainAgendaTecnicaView = new app.MainAgendaTecnicaView( );
        },
    }));
})(jQuery, this, this.document);