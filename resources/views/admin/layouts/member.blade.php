@extends('admin.layouts.app')

@section('app_content')
    <div class="row">
        <div class="col-12 col-xl-10 offset-xl-1">
            <x-admin.page-header>
                <x-admin.page-title>
                    {{ $member->getName() }}
                </x-admin.page-title>
            </x-admin.page-header>

            <div class="two-columns-layout">
                <div class="two-columns-layout-sidebar">
                    <div class="list-group list-group-flush mb-3">
                        <a href="{{ route('admin.member.show', $member) }}"
                            class="list-group-item list-group-item-action py-3 {{ request()->routeIs('admin.member.show') ? 'active' : '' }}">
                            <i class="fa-regular fa-user me-2 opacity-50" style="width: 20px;"></i>
                            {{ __('Profile') }}
                        </a>
                        <a href="#"
                            class="list-group-item list-group-item-action py-3 {{ request()->routeIs('admin.member.courses.*') ? 'active' : '' }}">
                            <i class="fa-regular fa-circle-play me-2 opacity-50" style="width: 20px;"></i>
                            {{ __('Courses') }}
                        </a>
                        <a href="#"
                            class="list-group-item list-group-item-action py-3 {{ request()->routeIs('admin.member.billing.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-pen-to-square me-2 opacity-50" style="width: 20px;"></i>
                            {{ __('Billing information') }}
                        </a>
                        <a href="#"
                            class="list-group-item list-group-item-action py-3 {{ request()->routeIs('admin.member.orders.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-receipt me-2 opacity-50" style="width: 20px;"></i>
                            {{ __('Orders') }}
                        </a>
                        <a href="#"
                            class="list-group-item list-group-item-action py-3 {{ request()->routeIs('admin.member.invoices.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-file-invoice me-2 opacity-50" style="width: 20px;"></i>
                            {{ __('Invoices') }}
                        </a>
                        <a href="#"
                            class="list-group-item list-group-item-action py-3 {{ request()->routeIs('admin.member.activity-log.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-file-invoice me-2 opacity-50" style="width: 20px;"></i>
                            {{ __('Activity log') }}
                        </a>
                        <a href="#"
                            class="list-group-item list-group-item-action py-3 {{ request()->routeIs('admin.member.settings.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-cog me-2 opacity-50" style="width: 20px;"></i>
                            {{ __('Settings') }}
                        </a>
                    </div>
                </div>
                <div class="two-columns-layout-content">
                    @yield('member_content')
                </div>
            </div>
        </div>
    </div>
@endsection
