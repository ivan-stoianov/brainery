@extends('admin.layouts.setting')

@section('setting_content')
    {{ html()->form('PUT')->route('admin.settings.update')->open() }}
    <div class="card mb-3">
        <div class="card-body">
            <div class="row gy-3">
                <div class="col-12">
                    {{ html()->label(__('Application name'), 'app_name')->class(['required']) }}
                    {{ html()->text('app_name', $app_name)->maxlength(20) }}
                    {{ html()->error('app_name') }}
                </div>
                <div class="col-12">
                    {{ html()->label(__('Member registration'), 'registration_enabled')->class(['required']) }}
                    {{ html()->select('registration_enabled', [1 => __('Enabled'), 0 => __('Disabled')], $registration_enabled) }}
                    {{ html()->error('registration_enabled') }}
                </div>
            </div>
        </div>
    </div>

    {{ html()->submit() }}
    {{ html()->form()->close() }}
@endsection
