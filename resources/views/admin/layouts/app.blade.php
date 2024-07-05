@extends('layouts.base', ['body_class' => request()->cookie('app_sidebar_hide') ? 'hide-app-sidebar' : ''])

@push('head')
    <meta name="admin-base-uri" content="{{ route('admin.home') }}">
    @livewireStyles
    @vite('resources/admin/scss/app.scss')
@endpush

@push('footer')
    @livewireScripts
    @vite('resources/admin/js/app.js')
@endpush

@section('base_content')
    {{-- START: App Header --}}
    <x-admin.app-header></x-admin.app-header>
    {{-- END: App Header --}}

    {{-- START: App Sidebar --}}
    <x-admin.app-sidebar>
        <x-slot:header>
            <a href="{{ route('admin.home') }}" class="app-sidebar-logo">
                {{ config('app.name') }}
            </a>
        </x-slot:header>
        <ul class="app-sidebar-menu">
            <li>
                <a href="{{ route('admin.home') }}"
                    class="{{ request()->routeIs('admin.home') ? 'active' : '' }} d-flex align-items-center justify-content-between">
                    <span>
                        <i class="fa-solid fa-dashboard app-sidebar-icon me-1"></i>
                        {{ __('Dashboard') }}
                    </span>
                    @if (request()->routeIs('admin.home'))
                        <i class="fa-solid fa-caret-right opacity-25"></i>
                    @endif
                </a>
            </li>
            <li>
                <a href="{{ route('admin.members.index') }}"
                    class="{{ request()->routeIs('admin.members.*', 'admin.member.*') ? 'active' : '' }} d-flex align-items-center justify-content-between">
                    <span>
                        <i class="fa-solid fa-user-graduate app-sidebar-icon me-1"></i>
                        {{ __('Members') }}
                    </span>
                    @if (request()->routeIs('admin.members.*', 'admin.member.*'))
                        <i class="fa-solid fa-caret-right opacity-25"></i>
                    @endif
                </a>
            </li>
        </ul>
    </x-admin.app-sidebar>
    {{-- END: App Sidebar --}}

    {{-- START: App Content --}}
    <main class="app-main-content">
        <div class="pt-4 pb-4">
            <div class="container">
                @yield('app_content')
            </div>
        </div>
    </main>
    {{-- END: App Content --}}

    <div class="app-sidebar-back"></div>
@endsection
