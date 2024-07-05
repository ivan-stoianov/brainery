@extends('layouts.base')

@push('head')
    @vite('resources/scss/app.scss')
@endpush

@push('footer')
    @vite('resources/js/app.js')
@endpush

@section('app_content')
@endsection
