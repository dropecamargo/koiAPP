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

            'puntosventa(/)': 'getPuntosVentaMain',
            'puntosventa/create(/)': 'getPuntosVentaCreate',
            'puntosventa/:puntoventa/edit(/)': 'getPuntosVentaEdit',

            //Tipos Actividad
            'tiposactividad(/)': 'getTiposActividadMain',
            'tiposactividad/create(/)': 'getTiposActividadCreate',
            'tiposactividad/:tipoactividad/edit(/)': 'getTiposActividadEdit',

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
            'productos/:producto/edit(/)': 'getProductosEdit',

            'pedidos(/)': 'getPedidosMain',
            'pedidos/create(/)': 'getPedidosCreate',
            'pedidos/:pedido/edit(/)': 'getPedidosEdit',

            'marcas(/)': 'getMarcasMain',
            'marcas/create(/)': 'getMarcasCreate',
            'marcas/:marcas/edit(/)': 'getMarcasEdit',

            'categorias(/)': 'getCategoriasMain',
            'categorias/create(/)': 'getCategoriasCreate',
            'categorias/:categorias/edit(/)': 'getCategoriasEdit',

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
            this.componentSearchTerceroView = new app.ComponentSearchTerceroView();
            this.componentTerceroView = new app.ComponentTerceroView();
            this.componentReporteView = new app.ComponentReporteView();
            this.componentCreateResourceView = new app.ComponentCreateResourceView();
            this.componentSearchCuentaView = new app.ComponentSearchCuentaView();

      	},

        /**
        * Start Backbone history
        */
        start: function () {
            var config = { pushState: true };

            if( document.domain.search(/(104.236.57.82|localhost)/gi) != '-1' )
                config.root = '/signsupply/public/';

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
        
        /*
        |-----------------------
        | Contabilidad
        |-----------------------
        */

        //Folder
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

        getProductosMain: function () {

            if ( this.mainProductosView instanceof Backbone.View ){
                this.mainProductosView.stopListening();
                this.mainProductosView.undelegateEvents();
            }

            this.mainProductosView = new app.MainProductosView( );
        },

        getProductosCreate: function () {
            this.productoModel = new app.ProductoModel();

            if ( this.createProductoView instanceof Backbone.View ){
                this.createProductoView.stopListening();
                this.createProductoView.undelegateEvents();
            }

            this.createProductoView = new app.CreateProductoView({ model: this.productoModel });
            this.createProductoView.render();
        },

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

        getPedidosMain: function () {

            if ( this.mainPedidosView instanceof Backbone.View ){
                this.mainPedidosView.stopListening();
                this.mainPedidosView.undelegateEvents();
            }

            this.mainPedidosView = new app.MainPedidosView( );
        },

        getPedidosCreate: function () {
            this.pedidoModel = new app.PedidoModel();

            if ( this.createPedidoView instanceof Backbone.View ){
                this.createPedidoView.stopListening();
                this.createPedidoView.undelegateEvents();
            }

            this.createPedidoView = new app.CreatePedidoView({ model: this.pedidoModel });
            this.createPedidoView.render();
        },

        getPedidosEdit: function (pedido) {
            this.pedidoModel = new app.PedidoModel();
            this.pedidoModel.set({'id': pedido}, {silent: true});

            if ( this.createPedidoView instanceof Backbone.View ){
                this.createPedidoView.stopListening();
                this.createPedidoView.undelegateEvents();
            }

            this.createPedidoView = new app.CreatePedidoView({ model: this.pedidoModel });
            this.pedidoModel.fetch();
        },

    }) );

})(jQuery, this, this.document);