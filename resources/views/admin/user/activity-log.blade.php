@extends('admin.layouts.user')

@section('user_content')
    <livewire:admin.user.activity-log.page :user-id="$user->getId()" />
@endsection
