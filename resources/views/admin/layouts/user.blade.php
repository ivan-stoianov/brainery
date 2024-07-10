@extends('admin.layouts.app')

@section('app_content')
    <div class="row">
        <div class="col-12 col-xl-10 offset-xl-1">
            <x-admin.page-header>
                <x-admin.page-title>
                    {{ $user->getName() }}
                </x-admin.page-title>
            </x-admin.page-header>

            {{ app('flash.message')->display() }}

            <div class="two-columns-layout">
                <div class="two-columns-layout-sidebar">
                    <div class="list-group list-group-flush mb-3">
                        <a href="{{ route('admin.user.show', $user) }}"
                            class="list-group-item list-group-item-action py-3 {{ request()->routeIs('admin.user.show') ? 'active' : '' }}">
                            <i class="fa-regular fa-user me-2 opacity-50" style="width: 20px;"></i>
                            {{ __('Profile') }}
                        </a>
                        <a href="{{ route('admin.user.activity-log.index', $user) }}"
                            class="list-group-item list-group-item-action py-3 {{ request()->routeIs('admin.user.activity-log.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-file-invoice me-2 opacity-50" style="width: 20px;"></i>
                            {{ __('Activity log') }}
                        </a>
                        <a href="{{ route('admin.user.settings.index', $user) }}"
                            class="list-group-item list-group-item-action py-3 {{ request()->routeIs('admin.user.settings.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-cog me-2 opacity-50" style="width: 20px;"></i>
                            {{ __('Settings') }}
                        </a>
                    </div>
                </div>
                <div class="two-columns-layout-content">
                    @yield('user_content')
                </div>
            </div>
        </div>
    </div>
@endsection
