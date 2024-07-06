@extends('admin.layouts.app')

@section('app_content')
    <div class="row">
        <div class="col-12 col-xl-10 offset-xl-1">

            <x-admin.page-header>
                <x-admin.page-title>
                    {{ __('Settings') }}
                </x-admin.page-title>
            </x-admin.page-header>

            {{ app('flash.message')->display() }}

            <div class="two-columns-layout">
                <div class="two-columns-layout-sidebar">
                    <div class="list-group list-group-flush mb-3">
                        <a href="{{ route('admin.settings.edit') }}"
                            class="list-group-item list-group-item-action py-3 {{ request()->routeIs('admin.settings.edit') ? 'active' : '' }}">
                            <i class="fa-solid fa-pen-to-square me-2 opacity-50" style="width: 20px;"></i>
                            {{ __('General') }}
                        </a>
                    </div>
                </div>
                <div class="two-columns-layout-content">
                    @yield('setting_content')
                </div>
            </div>
        </div>
    </div>
@endsection
