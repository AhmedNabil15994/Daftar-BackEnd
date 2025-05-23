<head>
    <meta charset="utf-8"/>
    <title>@yield('title', config('app.name')) - {{ config('app.name') }}</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>


    <link rel="stylesheet" type="text/css" href="{{ url('frontend/ar/css/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('frontend/ar/css/bootstrap-ar.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('frontend/ar/css/font-awesome.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('frontend/ar/css/themify-icons.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('frontend/ar/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('frontend/ar/css/chosen.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('frontend/ar/css/jquery.mCustomScrollbar-ar.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('frontend/ar/css/smoothproducts.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('frontend/ar/css/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('frontend/ar/css/style-ar.css') }}">

    <link rel="shortcut icon" href="{{url(config('setting.favicon'))}}"/>

    @yield('css')

    <style></style>

@include('apps::frontend.layouts._header_style')

<!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-194310115-1%22%3E"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());
        gtag('config', 'UA-194310115-1');
    </script>
</head>
