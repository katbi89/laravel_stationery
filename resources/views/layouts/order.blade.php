<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }} " dir="{{ app()->getLocale() == 'ar'? 'rtl' :'ltr'  }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name') }} | @yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    @yield('head')

    <link href="https://fonts.googleapis.com/css?family=Tajawal" rel="stylesheet">
</head>
<body>
@yield('content')

<script src="{{ asset('AdminLTE/bower_components/jquery/dist/jquery.min.js') }}"></script>

@yield('script')
</body>
</html>
