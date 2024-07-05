@extends('admin.layouts.app')

@section('app_content')
    <div>{{ __('Members') }}</div>

    @if ($members->count())
        <x-admin.table>
            <x-slot name="head">
                <x-admin.table.heading>{{ __('Name') }}</x-admin.table.heading>
                <x-admin.table.heading>{{ __('Email') }}</x-admin.table.heading>
                <x-admin.table.heading>{{ __('Status') }}</x-admin.table.heading>
                <x-admin.table.heading>{{ __('Register date') }}</x-admin.table.heading>
            </x-slot>

            @foreach ($members as $member)
                <x-admin.table.row>
                    <x-admin.table.column>
                        <a href="#" class="text-decoration-none fw-bold text-dark">
                            {{ $member->getName() }}
                        </a>
                    </x-admin.table.column>
                    <x-admin.table.column>
                        {{ $member->getEmail() }}
                    </x-admin.table.column>
                    <x-admin.table.column>
                        @if ($member->isActive())
                            <x-bs.badge variant="success">{{ __('Active') }}</x-bs.badge>
                        @else
                            <x-bs.badge variant="secondary">{{ __('Inactive') }}</x-bs.badge>
                        @endif
                    </x-admin.table.column>
                    <x-admin.table.column>
                        {{ $member->getCreatedAt()->toDateHuman() }}
                    </x-admin.table.column>
                </x-admin.table.row>
            @endforeach
        </x-admin.table>
    @endif

    {{ $members->render() }}
@endsection
