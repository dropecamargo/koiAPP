<ul class="notifications-list" id="notifications-list">
    @foreach( $notifications as $notification )
        @if( !$notification->notificacion_visto )
            <li class="item view-notification notification-true" data-notification="{{ $notification->id }}">
        @else
            <li class="item view-notification" data-notification="{{ $notification->id }}">
        @endif
            <div class="row">
                <div class="col-sm-6 text-left">
                    <p class="text-green">
                        <i class="fa fa-phone"></i>
                        {{ $notification->notificacion_titulo }}
                    </p>
                </div>
                <div class="col-sm-6 text-right">
                    <small><p class="text-green">{{ $notification->nfecha }}</p></small>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <span class="text-description">{{ $notification->notificacion_descripcion }}</span>
                </div>
            </div>
    @endforeach()
</ul>
{!! $notifications->render() !!}
