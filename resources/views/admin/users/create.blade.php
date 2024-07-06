@extends('admin.layouts.app')

@section('app_content')
    <div class="row">
        <div class="col-12 col-xl-6 col-xxl-6">

            {{ html()->form()->route('admin.users.store')->attribute('novalidate')->open() }}

            <div class="card">
                <div class="card-body p-4">
                    <div class="fs-5 mb-3 border-bottom pb-3">
                        {{ __('Register new user') }}
                    </div>
                    {{ app('flash.message')->display() }}
                    <div class="row gy-3 gx-2">
                        <div class="col-12 col-xl-6">
                            {{ html()->labelRequired(__('First name'), 'first_name')->class(['required']) }}
                            {{ html()->text('first_name') }}
                            {{ html()->error('first_name') }}
                        </div>
                        <div class="col-12 col-xl-6">
                            {{ html()->labelRequired(__('Last name'), 'last_name')->class(['required']) }}
                            {{ html()->text('last_name') }}
                            {{ html()->error('last_name') }}
                        </div>
                        <div class="col-12">
                            {{ html()->labelRequired(__('Email address'), 'email')->class(['required']) }}
                            {{ html()->email('email') }}
                            {{ html()->error('email') }}
                        </div>
                        <div class="col-12 col-xl-6">
                            {{ html()->label(__('Password'), 'password')->class(['required']) }}
                            {{ html()->password('password')->autocomplete('current-password') }}
                            {{ html()->error('password') }}
                        </div>
                        <div class="col-12 col-xl-6">
                            {{ html()->label(__('Confirm password'), 'password_confirmation')->class(['required']) }}
                            {{ html()->password('password_confirmation') }}
                            {{ html()->error('password_confirmation') }}
                        </div>
                        <div class="col-12">
                            {{ html()->submit() }}
                            {{ html()->buttonCancel(route('admin.users.index')) }}
                        </div>
                    </div>
                </div>
            </div>
            {{ html()->form()->close() }}
        </div>
    </div>
@endsection
