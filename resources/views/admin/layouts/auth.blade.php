@extends('layouts.base')

@push('head')
    @vite('resources/admin/scss/auth.scss')
@endpush

@push('footer')
    @vite('resources/admin/js/auth.js')
@endpush

@section('base_content')
    <div class="auth-layout">
        <div class="auth-content">
            @yield('auth_content')
        </div>
        <div class="auth-sidebar">

        </div>
    </div>
@endsection
