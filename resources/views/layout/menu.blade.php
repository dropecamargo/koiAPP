<ul class="sidebar-menu">
    <li class="header">Menú de navegación</li>
    <li class="{{ Request::route()->getName() == 'dashboard' ? 'active' : '' }}">
        <a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> <span>Dashboard </span></a>
    </li>

    {{-- Administracion --}}
    <li class="treeview {{ in_array(Request::segment(1), ['puntosventa','empresa', 'terceros', 'actividades', 'tiposactividad', 'documento', 'municipios', 'departamentos', 'sucursales','regionales', 'modulos', 'permisos', 'roles']) ? 'active' : '' }}">
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
            <li class="{{ in_array(Request::segment(1), ['puntosventa', 'modulos', 'permisos','actividades', 'municipios', 'documento', 'tiposactividad', 'departamentos', 'sucursales','regionales']) ? 'active' : '' }}">

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
                    
                </ul>
            </li> 
 		</ul>
    </li>

    {{-- Comercial --}}
    <li class="treeview {{ in_array(Request::segment(1), ['presupuestoasesor']) ? 'active' : '' }}">
        <a href="#">
            <i class="fa fa-globe"></i> <span>Comercial</span><i class="fa fa-angle-left pull-right"></i>
        </a>

        <ul class="treeview-menu">
            {{-- Modulos contabilidad --}}
            <li class="{{ in_array(Request::segment(1), ['presupuestoasesor']) ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-wpforms"></i> Módulos <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::segment(1) == 'presupuestoasesor' ? 'active' : '' }}">
                        <a href="{{ route('presupuestoasesor.index') }}"><i class="fa fa-handshake-o"></i> Presupuesto</a>
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
    <li class="treeview {{ in_array(Request::segment(1), ['unidades', 'productos','lineas','marcas','modelos','categorias','impuestos','pedidos','ajustes','tiposajuste','subcategorias','unidadesnegocio','traslados']) ? 'active' : '' }}">
        <a href="#">
            <i class="fa fa-list"></i> <span>Inventario</span><i class="fa fa-angle-left pull-right"></i>
        </a>

        <ul class="treeview-menu">
            {{-- Modulos inventario --}}
            <li class="{{ in_array(Request::segment(1), ['productos','pedidos','ajustes','traslados']) ? 'active' : '' }}">
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
                </ul>
            </li>

            {{-- Referencias inventario --}}
            <li class="{{ in_array(Request::segment(1), ['unidades','lineas','marcas','modelos','categorias','impuestos','tiposajuste','subcategorias','unidadesnegocio']) ? 'active' : '' }}">
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
                    <li class="{{Request::segment(1)== 'subcategorias' ? 'active' : ''}}">
                        <a href="{{route('subcategorias.index')}}"><i class="fa fa-circle-o"></i> Subcategorias</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'tiposajuste' ? 'active' : '' }}">
                        <a href="{{ route('tiposajuste.index') }}"><i class="fa fa-circle-o"></i> Tipo ajuste</a>
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
</ul>