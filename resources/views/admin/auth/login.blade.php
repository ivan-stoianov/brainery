@extends('admin.layouts.auth')

@section('auth_content')
    <div class="auth-card">
        <div class="text-center mb-5">
            <div class="fs-3 mb-2 fw-bold">
                {{ __('Welcome back!') }}
            </div>
            <div>
                {{ __('Please Sign In to continue') }}
            </div>
        </div>

        {{ app('flash.message')->display() }}

        {{ html()->form()->open() }}
        <div class="row gy-4">
            <div class="col-12">
                {{ html()->label(__('Email address'), 'email')->class(['required']) }}
                <div class="input-group">
                    <div class="input-group-text">
                        <i class="fa-regular fa-envelope"></i>
                    </div>
                    {{ html()->email('email')->autocomplete('username') }}
                </div>
                {{ html()->error('email') }}
            </div>
            <div class="col-12">
                {{ html()->label(__('Password'), 'password')->class(['required']) }}
                <div class="input-group">
                    <div class="input-group-text">
                        <i class="fa-solid fa-key"></i>
                    </div>
                    {{ html()->password('password')->autocomplete('current-password') }}
                </div>
                {{ html()->error('password') }}
            </div>
            <div class="col-12">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="form-check">
                            {{ html()->checkbox('remember') }}
                            {{ html()->label(__('Remember me'), 'remember')->forgetAttribute('class')->class('form-check-label') }}
                        </div>
                    </div>
                    <div class="col text-end">
                        <a href="#" class="text-decoration-none">
                            {{ __('Reset password') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-12">
                {{ html()->submit(__('Sign in'))->class('w-100') }}
            </div>
        </div>
        {{ html()->form()->close() }}
    </div>
@endsection
