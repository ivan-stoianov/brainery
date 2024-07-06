@extends('admin.layouts.user')

@section('user_content')
    <div class="card mb-3">
        <div class="card-body p-4">
            <div class="fs-5 mb-3 border-bottom pb-3">
                {{ __('User profile information') }}
            </div>
            <div class="row g-3">
                <div class="col-12 col-xl-6">
                    <div class="fw-bold mb-1">
                        {{ __('First name') }}
                    </div>
                    <div>{{ $user->getFirstName() }}</div>
                </div>
                <div class="col-12 col-xl-6">
                    <div class="fw-bold mb-1">
                        {{ __('Last name') }}
                    </div>
                    <div>{{ $user->getLastName() }}</div>
                </div>
                <div class="col-12 col-xl-6">
                    <div class="fw-bold mb-1">
                        {{ __('Email') }}
                    </div>
                    <div>
                        {{ $user->getEmail() }}
                    </div>
                </div>
                <div class="col-12 col-xl-6">
                    <div class="fw-bold mb-1">
                        {{ __('Register date') }}
                    </div>
                    <div>
                        {{ $user->getCreatedAt()->toDateHuman() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
