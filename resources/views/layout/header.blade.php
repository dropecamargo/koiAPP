<header class="main-header">
    <a href="{{ route('dashboard') }}" class="logo">
        <span class="logo-mini">S<b>S</b></span>
        {{-- logo for regular state and mobile devices --}}
        <span class="logo-lg"><b>{{ config('koi.app.name') }}</b></span>
    </a>

    {{-- Header Navbar: style can be found in header.less --}}
    <nav class="navbar navbar-static-top" role="navigation">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Navegación</span>
        </a>

        {{-- Navbar Right Menu --}}
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-bell"></i>
                    <span class="label label-danger">10</span>
                    </a>

                    <ul class="dropdown-menu">
                        <li class="header">Tienes {{ 10 }} notificaciones</li>
                        <li>
                            <ul class="menu">
                                <li>
                                    <a href="#">
                                        <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
                                    page and may cause design problems
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-users text-red"></i> 5 new members joined
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                    <i class="fa fa-user text-red"></i> You changed your username
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li> -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                         {{-- The user image in the navbar --}}
                        <img src="{{ asset(config('koi.app.image.avatar')) }}" class="user-image" alt="{{ Auth::user()->username }}"/>
                        {{-- hidden-xs hides the username on small devices so only the image appears. --}}
                        <span class="hidden-xs">{{ Auth::user()->getName() }}</span>
                    </a>

                    <ul class="dropdown-menu">
                        {{-- The user image in the menu --}}
                        <li class="user-header">
                            <img src="{{ asset(config('koi.app.image.avatar')) }}" class="img-circle" alt="User Image"/>
                            <p>{{ Auth::user()->getName() }}</p>
                        </li>
                        {{-- Menu Footer --}}
                        <li class="user-footer">
                            <div class="pull-right">
                                <a href="{{ route('logout') }}" class="btn btn-default btn-flat" title="{{ trans('app.logout') }}">
                                {{ trans('app.logout') }}
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>

<aside class="main-sidebar">
    <section class="sidebar">
        {{-- Sidebar user panel --}}
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset(config('koi.app.image.avatar')) }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->username }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        @include('layout.menu')
    </section>
  </aside>
