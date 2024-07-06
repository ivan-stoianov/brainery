@extends('admin.layouts.app')

@section('app_content')
    <div class="row">
        <div class="col-12 col-xl-6 offset-xl-3">
            <div class="text-center">
                <div class="fs-4 mb-3">
                    {{ __('Member user not found.') }}
                </div>
                <a href="{{ route('admin.members.index') }}" class="btn btn-outline-primary">
                    {{ __('Back to all members') }}
                </a>
            </div>
        </div>
    </div>
@endsection
