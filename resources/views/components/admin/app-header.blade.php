<header class="app-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-auto">
                <button type="button" class="btn btn-toggle-app-sidebar">
                    <i class="fa-solid fa-align-left"></i>
                </button>
            </div>
            <div class="col">
                {{ $slot }}
            </div>
            <div class="col-auto">
                @if (isset($right))
                    {{ $right }}
                @endif

                {{ html()->form()->class('d-inline')->open() }}

                <button type="submit" class="btn">
                    <i class="fa-solid fa-power-off me-md-2"></i>
                    <span class="d-none d-md-inline">{{ __('Logout') }}</span>
                </button>

                {{ html()->form()->close() }}
            </div>
        </div>
    </div>
</header>
