@extends('admin.layouts.app')

@section('app_content')
    <x-admin.page-header>
        <x-admin.page-title>
            {{ __('Members') }}
        </x-admin.page-title>
    </x-admin.page-header>

    <livewire:admin.members.index.page />
@endsection
