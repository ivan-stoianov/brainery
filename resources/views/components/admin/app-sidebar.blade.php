<aside class="app-sidebar">
    <div class="app-sidebar-header">
        @if (isset($header))
            {{ $header }}
        @else
            <a href="{{ route('admin.home') }}" class="app-sidebar-logo">
                {{ config('app.name') }}
            </a>
        @endif
    </div>
    <div class="app-sidebar-body">
        {{ $slot }}
    </div>
</aside>
