@extends('admin.layouts.app')

@section('app_content')
    <x-admin.page-header>
        <div class="row align-items-end">
            <div class="col">
                <x-admin.page-title>
                    {{ __('Users') }}
                </x-admin.page-title>
            </div>
            <div class="col-auto">
                <x-admin.anchor-add href="{{ route('admin.users.create') }}">
                    {{ __('Register new user') }}
                </x-admin.anchor-add>
            </div>
        </div>
    </x-admin.page-header>

    <livewire:admin.users.index.page />
@endsection
