<header class="main-header">
    <a href="{{ route('dashboard') }}" class="logo">
        <span class="logo-mini"><img src="{{ asset(env('APP_LOGO')) }}" width="40" height="40"/></span>
        {{-- logo for regular state and mobile devices --}}
        <span class="logo-lg"><b>{{ env('APP_NAME') }}</b></span>
    </a>

    {{-- Header Navbar: style can be found in header.less --}}
    <nav class="navbar navbar-static-top" role="navigation">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Navegación</span>
        </a>

        {{-- Navbar Right Menu --}}
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                {{--*/ $detalle = App\Models\Base\Notificacion::getCountNotifications() /*--}}

                {{-- Menu notificaciones --}}
                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-bell"></i>
                        <span class="label label-danger">{{ $detalle > 0 ? $detalle : '' }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">{{ $detalle > 0 ? 'Tienes '.$detalle.' notificaciones' : 'No tiene notificaciones' }}</li>
                        <li>
                            <ul class="menu">
                                @foreach( App\Models\Base\Notificacion::getNotifications() as $key => $value)
                                    <li>
                                        @if( !$value['notificacion_visto'] )
                                            <a class="view-notification notification-true" data-notification="{{ $value['id'] }}">
                                        @else
                                            <a class="view-notification" data-notification="{{ $value['id'] }}">
                                        @endif
                                            <div class="pull-left">
                                                <i class="fa fa-phone text-green"></i>
                                            </div>
                                            <h4 class="text-green">
                                                {{ $value['notificacion_titulo'] }}
                                                <small class="text-green">{{ $value['nfecha'] }}</small>
                                            </h4>
                                            <p class="text-black">{{ $value['notificacion_descripcion'] }}</p>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="footer"><a class="view-all-notification">{{ trans('notification.view') }}</a></li>
                    </ul>
                </li>
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                         {{-- The user image in the navbar --}}
                        <img src="{{ asset(config('koi.app.avatar')) }}" class="user-image" alt="{{ Auth::user()->username }}"/>
                        {{-- hidden-xs hides the username on small devices so only the image appears. --}}
                        <span class="hidden-xs">{{ Auth::user()->getName() }}</span>
                    </a>

                    <ul class="dropdown-menu">
                        {{-- The user image in the menu --}}
                        <li class="user-header">
                            <img src="{{ asset(config('koi.app.avatar')) }}" class="img-circle" alt="User Image"/>
                            <p>{{ Auth::user()->getName() }}</p>
                        </li>
                        {{-- Menu Footer --}}
                        <li class="user-footer">
                            <div class="pull-right">
                                <a href="{{ route('auth.logout') }}" class="btn btn-default btn-flat" title="{{ trans('app.logout') }}">
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
                <img src="{{ asset(config('koi.app.avatar')) }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->username }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        @include('layout.menu')
    </section>
  </aside>
