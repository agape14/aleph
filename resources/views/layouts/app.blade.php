<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Colegio Áleph')</title>
    <meta name="description" content=" " />
    <meta name="keywords" content="" />
    <meta content="Themesdesign" name="Agapito De la cruz Carlos" />
    <link rel="shortcut icon" href="{{ asset('images/aleph-favicon.ico') }} ">

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <!-- Bootstrap css -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" type="text/css" id="bootstrap-style" />

    <!-- Material Icon Css -->
    <link rel="stylesheet" href="{{ asset('css/materialdesignicons.min.css') }}" type="text/css" />

    <!-- Unicon Css -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />

    <!-- Swiper Css -->
    <link rel="stylesheet" href="{{ asset('css/tiny-slider.css') }} " type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/swiper.min.css') }} " type="text/css" />

    <!-- Custom Css -->
    <link rel="stylesheet" href="{{ asset('css/style.min.css') }} " type="text/css" />

    <!-- colors -->
    <link href="{{ asset('css/colors/default.css') }} " rel="stylesheet" type="text/css" id="color-opt" />

    @yield('head')
</head>
<body data-bs-spy="scroll" data-bs-target="#navbarCollapse">
    @include('partials.header')
    <main>
        @yield('content')
    </main>
    @include('partials.footer')
    @yield('scripts')
</body>
</html>
