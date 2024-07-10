@extends('admin.layouts.user')

@section('user_content')
    {{ html()->form('PATCH')->route('admin.user.settings.update', $user)->open() }}
    <div class="card mb-3">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-12 col-xl-6">
                    {{ html()->labelRequired(__('First name'), 'first_name') }}
                    {{ html()->text('first_name', $user->getFirstName()) }}
                    {{ html()->error('first_name') }}
                </div>
                <div class="col-12 col-xl-6">
                    {{ html()->labelRequired(__('Last name'), 'last_name') }}
                    {{ html()->text('last_name', $user->getLastName()) }}
                    {{ html()->error('last_name') }}
                </div>
                <div class="col-12">
                    {{ html()->submit() }}
                </div>
            </div>
        </div>
    </div>
    {{ html()->form()->close() }}

    @can('enableAccount', $user)
        {{ html()->form('PATCH')->route('admin.user.settings.enable', $user)->open() }}
        <div class="card mb-3">
            <div class="card-body">
                <button type="submit" class="btn btn-success">
                    {{ __('Enable account') }}
                </button>
            </div>
        </div>
        {{ html()->form()->close() }}
    @endcan

    @can('disableAccount', $user)
        {{ html()->form('PATCH')->route('admin.user.settings.disable', $user)->open() }}
        <div class="card mb-3">
            <div class="card-body">
                <button type="submit" class="btn btn-danger">
                    {{ __('Disable account') }}
                </button>
            </div>
        </div>
        {{ html()->form()->close() }}
    @endcan
@endsection
