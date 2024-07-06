@extends('admin.layouts.app')

@section('app_content')
    <div class="row">
        <div class="col-12 col-xl-6 offset-xl-3">
            <div class="text-center">
                <div class="fs-4 mb-3">
                    {{ __('Admin user not found.') }}
                </div>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary">
                    {{ __('Back to all users') }}
                </a>
            </div>
        </div>
    </div>
@endsection
