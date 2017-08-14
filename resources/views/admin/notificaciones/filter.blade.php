<ul class="notifications-list" id="notifications-list">
    @foreach( $notifications as $notification )
        @if( !$notification->notificacion_visto )
            <li class="item view-notification visto-notification" data-notification="{{ $notification->id }}">
        @else
            <li class="item view-notification" data-notification="{{ $notification->id }}">
        @endif
            <div class="notification-text">
                <div class="row">
                    <div class="col-md-6 text-left">
                        <i class="fa fa-phone text-green">{{ $notification->notificacion_titulo }}</i>
                    </div>
                    <div class="col-md-6 text-right">
                        <span class="notification-fecha">{{ $notification->nfecha }}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <span class="notification-description text-black">{{ $notification->notificacion_descripcion }}</span>
                    </div>
                </div>
            </div>
        </li>
    @endforeach()
</ul>
{!! $notifications->render() !!}
