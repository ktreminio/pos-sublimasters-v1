<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="@yield('description')"/>
    <title>{{ config('app.name', 'Laravel') }} | @lang('menu.'.request()->route()->getName())</title>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="{{ asset( 'assets/css/plugin' . Helper::rlt_ext() . '.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style' . Helper::rlt_ext() . '.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/variables' . Helper::rlt_ext() . '.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app' . Helper::rlt_ext() . '.css') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/favicon.png') }}">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v3.0.0/css/line.css">
    <link rel="stylesheet" href="{{ asset('assets/css/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-drawer/1.0.6/css/bootstrap-drawer.min.css" integrity="sha512-L07i7ll0EnJDKz/EAHtyaxRppBD55peHINGxMuo48F59s+1N2XRJZYEQfDpfRyLiYBqmlKCAhaxiY2WnpC4q/Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />


    @yield('styles')

    @livewireStyles
</head>

<body @auth class="layout-light side-menu" @endauth>
    {{ $slot }}

    <script>
        var env = {
            iconLoaderUrl: "{{ asset('assets/js/json/icons.json') }}",
            googleMarkerUrl: "{{ asset('assets/img/markar-icon.png') }}",
            editorIconUrl: "{{ asset('assets/img/ui/icons.svg') }}",
            mapClockIcon: "{{ asset('assets/img/svg/clock-ticket1.sv') }}g"
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDduF2tLXicDEPDMAtC6-NLOekX0A5vlnY"></script>
    <script src="{{ asset('assets/js/plugins.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.min.js') }}"></script>
    <script src="{{ asset('js/app.min.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-drawer/1.0.6/js/drawer.min.js" integrity="sha512-Wh3lP9w7lSb/YxUiRVSCp3vB6K4mheETB2oxfSpPBFsqjUkChxZiRZ2jii+2gJ+rP1lDMy5dEiOvM4fkEN4WGA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    @livewireScripts

    <script src="{{ asset('vendor/livewire-alert/livewire-alert.js') }}"></script>
    <x-livewire-alert::flash />

    @yield('scripts')
</body>
</html>
