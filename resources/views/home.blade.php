@extends('layouts.app')

@section('app_content')
    {{ app('flash.message')->display() }}
@endsection
