<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>UO | Exam System</title>
    <link rel="icon" href="{{ asset('/images/logo/logo-light.png') }}">
    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Styles -->
    @vite(['resources/js/app.js','resources/css/app.css'])

    <!-- <link rel="stylesheet" href="{{ asset('/build/assets/app.css') }}">
    <script src="{{ asset('/build/assets/app.js') }}"></script> -->

    <script src="{{ asset('/fonts/bootstrap-icons/bootstrap-icons.min.css') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body>
    @yield('header')
    @yield('sidebar')
    @yield('body')

    <script src="{{asset('js/sweetalert2@10.js')}}"></script>
    <script src="{{asset('js/toast.js')}}"></script>
    <script type="module" src="{{asset('js/collapsible.js')}}"></script>

    @yield('script')
    @yield('footer')
</body>

</html>