<ul class="sidebar-menu">
    <li class="header">Menú de navegación</li>
    <li class="{{ Request::route()->getName() == 'dashboard' ? 'active' : '' }}">
        <a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> <span>Dashboard </span></a>
    </li>

    {{-- Administracion --}}
    <li class="treeview {{ in_array(Request::segment(1), ['puntosventa','empresa', 'terceros', 'actividades', 'tiposactividad', 'documento', 'municipios', 'departamentos', 'sucursales','ubicaciones','regionales', 'modulos', 'permisos', 'roles','paises']) ? 'active' : '' }}">
        <a href="{{ route('dashboard') }}">
            <i class="fa fa-cog"></i> <span>Administración</span><i class="fa fa-angle-left pull-right"></i>
        </a>

        <ul class="treeview-menu">
            {{-- Modulos administracion --}}
            <li class="{{ in_array(Request::segment(1), ['empresa', 'terceros', 'roles']) ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-wpforms"></i> Módulos <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::segment(1) == 'empresa' ? 'active' : '' }}">
                        <a href="{{ route('empresa.index') }}"><i class="fa fa-building"></i> Empresa</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'terceros' ? 'active' : '' }}">
                        <a href="{{ route('terceros.index') }}"><i class="fa fa-users"></i> Terceros</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'roles' ? 'active' : '' }}">
                        <a href="{{ route('roles.index') }}"><i class="fa fa-address-card-o"></i> Roles</a>
                    </li>
                </ul>
            </li>

            {{-- Referencias administracion --}}
            <li class="{{ in_array(Request::segment(1), ['puntosventa', 'modulos', 'permisos','actividades', 'municipios', 'documento', 'tiposactividad', 'departamentos', 'sucursales','ubicaciones','regionales','paises']) ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-circle-o"></i> Referencias <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::segment(1) == 'actividades' ? 'active' : '' }}">
                        <a href="{{ route('actividades.index') }}"><i class="fa fa-circle-o"></i> Actividades</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'departamentos' ? 'active' : '' }}">
                        <a href="{{ route('departamentos.index') }}"><i class="fa fa-circle-o"></i> Departamentos</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'documento' ? 'active' : '' }}">
                        <a href="{{ route('documento.index') }}"><i class="fa fa-circle-o"></i> Documentos</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'modulos' ? 'active' : '' }}">
                        <a href="{{ route('modulos.index') }}"><i class="fa fa-circle-o"></i> Modulos</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'municipios' ? 'active' : '' }}">
                        <a href="{{ route('municipios.index') }}"><i class="fa fa-circle-o"></i> Municipios</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'paises' ? 'active' : '' }}">
                        <a href="{{ route('paises.index') }}"><i class="fa fa-circle-o"></i> Paises</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'permisos' ? 'active' : '' }}">
                        <a href="{{ route('permisos.index') }}"><i class="fa fa-circle-o"></i> Permisos</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'puntosventa' ? 'active' : '' }}">
                        <a href="{{ route('puntosventa.index') }}"><i class="fa fa-circle-o"></i> Puntos de venta</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'regionales' ? 'active' : '' }}">
                        <a href="{{ route('regionales.index') }}"><i class="fa fa-circle-o"></i> Regionales</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'sucursales' ? 'active' : '' }}">
                        <a href="{{ route('sucursales.index') }}"><i class="fa fa-circle-o"></i> Sucursales</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'tiposactividad' ? 'active' : '' }}">
                        <a href="{{ route('tiposactividad.index') }}"><i class="fa fa-circle-o"></i> Tipo actividad</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'ubicaciones' ? 'active' : '' }}">
                        <a href="{{ route('ubicaciones.index') }}"><i class="fa fa-circle-o"></i> Ubicaciones</a>
                    </li>
                </ul>
            </li> 
        </ul>
    </li>

    {{--Cartera--}}
    <li class="{{ in_array(Request::segment(1), ['autorizacionesca','bancos','conceptosrc','conceptocobros','cuentabancos','autorizaco','mediopagos', 'recibos', 'conceptonotas', 'notas','facturas','conceptosajustec','ajustesc','devoluciones','anticipos','cheques','chequesdevueltos','gestioncobros','causas']) ? 'active' : '' }}">
        <a href="#">
            <i class="fa fa-suitcase"></i> <span>Cartera</span><i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li class="{{ in_array(Request::segment(1), ['recibos', 'notas','facturas', 'ajustesc', 'devoluciones','anticipos','cheques','gestioncobros','chequesdevueltos']) ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-wpforms"></i> Módulos <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">

                    <li class="{{ Request::segment(1) == 'ajustesc' ? 'active' : '' }}">
                        <a href="{{ route('ajustesc.index') }}"><i class="fa fa-adjust"></i> Ajuste cartera</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'anticipos' ? 'active' : '' }}">
                        <a href="{{ route('anticipos.index') }}"><i class="fa fa-caret-square-o-left"></i> Anticipos</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'chequesdevueltos' ? 'active' : '' }}">
                        <a href="{{ route('chequesdevueltos.index') }}"><i class="fa fa-list-alt"></i> Cheques devueltos</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'cheques' ? 'active' : '' }}">
                        <a href="{{ route('cheques.index') }}"><i class="fa fa fa-credit-card"></i> Cheques posfechados</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'devoluciones' ? 'active' : '' }}">
                        <a href="{{ route('devoluciones.index') }}"><i class="fa fa-reply"></i> Devoluciones</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'facturas' ? 'active' : '' }}">
                        <a href="{{ route('facturas.index') }}"><i class="fa fa-pencil-square-o"></i> Facturas</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'gestioncobros' ? 'active' : '' }}">
                        <a href="{{ route('gestioncobros.index') }}"><i class="fa fa-volume-control-phone"></i> Gestion Cobros</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'notas' ? 'active' : '' }}">
                        <a href="{{ route('notas.index') }}"><i class="fa fa-book"></i> Notas</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'recibos' ? 'active' : '' }}">
                        <a href="{{ route('recibos.index') }}"><i class="fa fa-file-text-o"></i> Recibos de caja</a>
                    </li>
                </ul>
            </li>
            {{--Referencias Cartera--}}
            <li class="{{ in_array(Request::segment(1), ['autorizacionesca','bancos','conceptosrc','cuentabancos','autorizaco','mediopagos', 'conceptonotas','conceptosajustec','conceptocobros', 'causas']) ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-circle-o"></i> Referencias <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::segment(1) == 'autorizacionesca' ? 'active' : '' }}">
                        <a href="{{route('autorizacionesca.index')}}"><i class="fa fa-circle-o"></i> Autorización Cartera</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'bancos' ? 'active' : '' }}">
                        <a href="{{route('bancos.index')}}"><i class="fa fa-circle-o"></i> Bancos</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'causas' ? 'active' : '' }}">
                        <a href="{{route('causas.index')}}"><i class="fa fa-circle-o"></i> Causas</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'cuentabancos' ? 'active' : '' }}">
                        <a href="{{route('cuentabancos.index')}}"><i class="fa fa-circle-o"></i> Cuentas de banco</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'conceptonotas' ? 'active' : '' }}">
                        <a href="{{route('conceptonotas.index')}}"><i class="fa fa-circle-o"></i> Concepto de nota</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'conceptocobros' ? 'active' : '' }}">
                        <a href="{{route('conceptocobros.index')}}"><i class="fa fa-circle-o"></i> Concepto cobro</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'conceptosajustec' ? 'active' : '' }}">
                        <a href="{{route('conceptosajustec.index')}}"><i class="fa fa-circle-o"></i> Concepto ajuste</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'conceptosrc' ? 'active' : '' }}">
                        <a href="{{route('conceptosrc.index')}}"><i class="fa fa-circle-o"></i> Concepto recibo de caja</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'mediopagos' ? 'active' : '' }}">
                        <a href="{{route('mediopagos.index')}}"><i class="fa fa-circle-o"></i> Medios de pago</a>
                    </li>
                    {{--<li class="{{ Request::segment(1) == 'autorizaco' ? 'active' : ''}}">
                        <a href="#"><i class="fa fa-circle-o"></i> Autorización Cobro</a>
                    </li>--}}
                </ul>
            </li>
        </ul>
    </li>

    {{-- Comercial --}}
    <li class="treeview {{ in_array(Request::segment(1), ['presupuestoasesor', 'pedidosc', 'gestionescomercial' ,'conceptoscomercial']) ? 'active' : '' }}">
        <a href="#">
            <i class="fa fa-globe"></i> <span>Comercial</span><i class="fa fa-angle-left pull-right"></i>
        </a>

        <ul class="treeview-menu">
            {{-- Modulos comercial --}}
            <li class="{{ in_array(Request::segment(1), ['presupuestoasesor', 'pedidosc','gestionescomercial']) ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-wpforms"></i> Módulos <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::segment(1) == 'gestionescomercial' ? 'active' : '' }}">
                        <a href="{{route('gestionescomercial.index')}}"><i class="fa fa-volume-control-phone"></i> Gestión comercial</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'pedidosc' ? 'active' : '' }}">
                        <a href="{{route('pedidosc.index')}}"><i class="fa fa-cube"></i> Pedidos</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'presupuestoasesor' ? 'active' : '' }}">
                        <a href="{{ route('presupuestoasesor.index') }}"><i class="fa fa-handshake-o"></i> Presupuesto</a>
                    </li>
                </ul>
            </li>
            {{--Referencias--}}
            <li class="{{ in_array(Request::segment(1), ['conceptoscomercial']) ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-circle-o"></i> Referencias <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::segment(1) == 'conceptoscomercial' ? 'active' : '' }}">
                        <a href="{{route('conceptoscomercial.index')}}"> <i class="fa fa-circle-o"></i> Concepto comercial</a>
                    </li>
                </ul>
            </li>
        </ul>
    </li>

    {{-- Contabilidad --}}
    <li class="treeview {{ in_array(Request::segment(1), ['asientos', 'folders','documentos','plancuentas','centroscosto','rplancuentas','rmayorbalance']) ? 'active' : '' }}">
        <a href="#">
            <i class="fa fa-book"></i> <span>Contabilidad</span><i class="fa fa-angle-left pull-right"></i>
        </a>

        <ul class="treeview-menu">
            {{-- Modulos contabilidad --}}
            <li class="{{ in_array(Request::segment(1), ['asientos']) ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-wpforms"></i> Módulos <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::segment(1) == 'asientos' ? 'active' : '' }}">
                        <a href="{{ route('asientos.index') }}"><i class="fa fa-file-text-o"></i> Asientos</a>
                    </li>
                </ul>
            </li>

            {{-- Reportes contabilidad --}}
            <li class="{{ in_array(Request::segment(1), ['rplancuentas', 'rmayorbalance']) ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-bar-chart-o"></i> Reportes <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::segment(1) == 'rplancuentas' ? 'active' : '' }}">
                        <a href="{{ route('rplancuentas.index') }}"><i class="fa fa-circle-o"></i> Plan cuentas</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'rmayorbalance' ? 'active' : '' }}">
                        <a href="{{ route('rmayorbalance.index') }}"><i class="fa fa-circle-o"></i> Mayor y balance</a>
                    </li>
                </ul>
            </li>

            {{-- Referencias Contabilidad --}}
            <li class="{{ in_array(Request::segment(1), ['folders','centroscosto','documentos','plancuentas']) ? 'active' : '' }}">

                <a href="#">
                    <i class="fa fa-circle-o"></i> Referencias <i class="fa fa-angle-left pull-right"></i>
                </a>

                <ul class="treeview-menu">
                    <li class="{{ Request::segment(1) == 'centroscosto' ? 'active' : '' }}">
                        <a href="{{ route('centroscosto.index') }}"><i class="fa fa-circle-o"></i> Centros de costo</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'documentos' ? 'active' : '' }}">
                        <a href="{{ route('documentos.index') }}"><i class="fa fa-circle-o"></i> Documentos</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'folders' ? 'active' : '' }}">
                        <a href="{{ route('folders.index') }}"><i class="fa fa-circle-o"></i> Folders</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'plancuentas' ? 'active' : '' }}">
                        <a href="{{ route('plancuentas.index') }}"><i class="fa fa-circle-o"></i> Plan de cuentas</a>
                    </li>
                </ul>
            </li>
        </ul>
    </li>

    {{-- Inventario --}}
    <li class="treeview {{ in_array(Request::segment(1), ['unidades', 'productos','lineas','marcas','modelos','categorias','impuestos','pedidos','ajustes','tiposajuste','subcategorias','servicios','unidadesnegocio','traslados','trasladosubicaciones','tipostraslados']) ? 'active' : '' }}">
        <a href="#">
            <i class="fa fa-list"></i> <span>Inventario</span><i class="fa fa-angle-left pull-right"></i>
        </a>

        <ul class="treeview-menu">
            {{-- Modulos inventario --}}
            <li class="{{ in_array(Request::segment(1), ['productos','pedidos','ajustes','traslados','trasladosubicaciones']) ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-wpforms"></i> Módulos <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::segment(1) == 'ajustes' ? 'active' : '' }}">
                        <a href="{{ route('ajustes.index') }}"><i class="fa fa-cog"></i> Ajustes</a>
                    </li> 
                    <li class="{{ Request::segment(1) == 'productos' ? 'active' : '' }}">
                        <a href="{{ route('productos.index') }}"><i class="fa fa-barcode"></i> Productos</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'pedidos' ? 'active' : '' }}">
                        <a href="{{ route('pedidos.index') }}"><i class="fa fa-cubes"></i> Pedidos</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'traslados' ? 'active' : '' }}">
                        <a href="{{ route('traslados.index') }}"><i class="fa fa-arrows"></i> Traslados</a>
                    </li> 
                    <li class="{{ Request::segment(1) == 'trasladosubicaciones' ? 'active' : '' }}">
                        <a href="{{ route('trasladosubicaciones.index') }}"><i class="fa fa-compass "></i> Traslados ubicaciones</a>
                    </li> 
                </ul>
            </li>
            {{--Reportes inventario--}}
            <li class="">
                <a href="#">
                    <i class="fa fa-bar-chart-o"></i> Reportes<i class= "fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="">
                        <a href="#"><i class="fa fa-circle-o"></i> Reporte1</a>
                    </li>
                </ul>
            </li>

            {{-- Referencias inventario --}}
            <li class="{{ in_array(Request::segment(1), ['unidades','lineas','marcas','modelos','categorias','impuestos','tiposajuste','tipostraslados','subcategorias','unidadesnegocio','servicios']) ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-circle-o"></i> Referencias <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{Request::segment(1)== 'categorias' ? 'active' : ''}}">
                        <a href="{{route('categorias.index')}}"><i class="fa fa-circle-o"></i> Categorias</a>
                    </li>
                    <li class="{{Request::segment(1)== 'impuestos' ? 'active' : ''}}">
                        <a href="{{route('impuestos.index')}}"><i class="fa fa-circle-o"></i> Impuestos</a>
                    </li>
                    <li class="{{Request::segment(1)== 'lineas' ? 'active' : ''}}">
                        <a href="{{route('lineas.index')}}"><i class="fa fa-circle-o"></i> Lineas</a>
                    </li>
                    <li class="{{Request::segment(1)== 'marcas' ? 'active' : ''}}">
                        <a href="{{route('marcas.index')}}"><i class="fa fa-circle-o"></i> Marcas</a>
                    </li>
                    <li class="{{Request::segment(1)== 'modelos' ? 'active' : ''}}">
                        <a href="{{route('modelos.index')}}"><i class="fa fa-circle-o"></i> Modelos</a>
                    </li>
                    <li class="{{Request::segment(1)== 'servicios' ? 'active' : ''}}">
                        <a href="{{route('servicios.index')}}"><i class="fa fa-circle-o"></i> Servicios</a>
                    </li>
                    <li class="{{Request::segment(1)== 'subcategorias' ? 'active' : ''}}">
                        <a href="{{route('subcategorias.index')}}"><i class="fa fa-circle-o"></i> Subcategorias</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'tiposajuste' ? 'active' : '' }}">
                        <a href="{{ route('tiposajuste.index') }}"><i class="fa fa-circle-o"></i> Tipo ajuste</a>
                    </li>
                     <li class="{{ Request::segment(1) == 'tipostraslados' ? 'active' : '' }}">
                        <a href="{{ route('tipostraslados.index') }}"><i class="fa fa-circle-o"></i> Tipo traslado</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'unidades' ? 'active' : '' }}">
                        <a href="{{ route('unidades.index') }}"><i class="fa fa-circle-o"></i> Unidades</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'unidadesnegocio' ? 'active' : '' }}">
                        <a href="{{ route('unidadesnegocio.index') }}"><i class="fa fa-circle-o"></i> Unidades Negocio</a>
                    </li>
                </ul>
            </li>
        </ul>
    </li>
    {{-- Tecnico --}}
    <li class="treeview {{ in_array(Request::segment(1), ['contratos','ordenes','tiposorden','solicitantes', 'sitios', 'danos','prioridades','conceptostecnico','gestionestecnico', 'soportetecnico']) ? 'active' : '' }}">
        <a href="#">
            <i class="fa fa-cogs"></i> <span>Tecnico</span><i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            {{-- Modulos Tecnico --}}
            <li class="{{ in_array(Request::segment(1), ['ordenes','gestionestecnico', 'soportetecnico']) ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-wpforms"></i> Modulos <i class="fa fa-angle-left pull-right"></i>
                </a>
                    <ul class="treeview-menu">
                    <li class="{{ Request::segment(1) == 'gestionestecnico' ? 'active' : '' }}">
                        <a href="{{ route('gestionestecnico.index') }}"><i class="fa fa-volume-control-phone"></i> Gestión tecnico</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'ordenes' ? 'active' : '' }}">
                        <a href="{{ route('ordenes.index') }}"><i class="fa fa-building-o"></i> Ordenes</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'soportetecnico' ? 'active' : '' }}">
                        <a href="{{ route('soportetecnico.index') }}"><i class="fa fa-address-book"></i> Soporte tecnico</a>
                    </li>
                </ul>
            </li>
      
            {{-- Referencias Tecnico --}}
            <li class="{{ in_array(Request::segment(1), ['tiposorden','solicitantes','danos','prioridades','conceptostecnico', 'sitios']) ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-circle-o"></i> Referencias <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::segment(1) == 'conceptostecnico' ? 'active' : '' }}">
                        <a href="{{ route('conceptostecnico.index') }}"><i class="fa fa-circle-o"></i> Concepto tecnico</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'danos' ? 'active' : '' }}">
                        <a href="{{ route('danos.index') }}"><i class="fa fa-circle-o"></i> Daños</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'prioridades' ? 'active' : '' }}">
                        <a href="{{ route('prioridades.index') }}"><i class="fa fa-circle-o"></i> Prioridades</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'sitios' ? 'active' : '' }}">
                        <a href="{{ route('sitios.index') }}"><i class="fa fa-circle-o"></i> Sitios de atención</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'solicitantes' ? 'active' : '' }}">
                        <a href="{{ route('solicitantes.index') }}"><i class="fa fa-circle-o"></i> Solicitantes</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'tiposorden' ? 'active' : '' }}">
                        <a href="{{ route('tiposorden.index') }}"><i class="fa fa-circle-o"></i> Tipo de Orden</a>
                    </li>
                </ul>
            </li>
        </ul>
    </li>
</ul>