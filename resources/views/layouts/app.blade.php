@extends('layouts.base')

@push('head')
    @vite('resources/scss/app.scss')
@endpush

@push('footer')
    @vite('resources/js/app.js')
@endpush

@section('base_content')
    @yield('app_content')
@endsection
