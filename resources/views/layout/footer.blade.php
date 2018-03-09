<footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
        Desarrollado por
        <a href="{{ config('koi.site') }}" title="{{ config('koi.name') }}" target="_blank">
            <img src="{{ asset(config('koi.image')) }}" alt="{{ config('koi.name') }}" width="50px">
        </a>
        <a href="{{ config('koi.site') }}" title="{{ config('koi.name') }}" target="_blank">
            {{ config('koi.nickname') }}
        </a>
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; {{ date('Y') }} <a href="{{ env('APP_SITE') }}" target="_blank">{{ env('APP_NAME') }}</a>.</strong> Todos los derechos reservados.
</footer>
