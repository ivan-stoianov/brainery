@extends('layouts.base')

@push('head')
    @vite('resources/admin/scss/app.scss')
@endpush

@push('footer')
    @vite('resources/admin/js/app.js')
@endpush

@section('base_content')
    @yield('app_content')
@endsection
