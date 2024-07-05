<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    {{ app('seo.meta.tools')->generate() }}
    @stack('head')
</head>

<body {!! isset($body_class) ? 'class="' . $body_class . '"' : '' !!}>
    @yield('base_content')
    @stack('footer')
</body>

</html>
