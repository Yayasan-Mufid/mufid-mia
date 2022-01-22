<!doctype html>
<html lang="{{ htmlLang() }}" @langrtl dir="rtl" @endlangrtl>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ appName() }} | @yield('title')</title>
    <meta name="description" content="@yield('meta_description', appName())">
    <meta name="author" content="@yield('meta_author', 'asif')">
    <link rel="icon" type="image/x-icon" href="favicon.png">
    @yield('meta')

    @stack('before-styles')
    <link href="{{ mix('css/backend.css') }}" rel="stylesheet">
    <style>
        .kotak {
            border: #e4e7e9 solid 1px;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 5px;
        }
        .kotak:hover {
            /* border: #cf1418 solid 1px; */
            /* background-color: #f7f7f7; */
            border: #cf1418 solid 1px;
        }

        .kotak-atas {
            padding: 10px;
            background-color: #e4e7e9;
            border-radius: 5px;
            margin-bottom: 4px;
        }

        .kotak-input {
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 4px;
        }

        a {
            color: #cf1418;
        }
        a:hover {
            color: #555;
            text-decoration: none;
        }

        /* .legend .row:nth-of-type(odd) div {
            background:#999999;
        }
        .legend .row:nth-of-type(even) div {
            background: #FFFFFF; */
        }

        .tampilloading .swal2-popup {
            background: rgba(0, 0, 0, 0);
        }
        .frontend .custom-toggler .navbar-toggler {
            border-color: #f7f7f7;
        }

        .zoom {
            position: relative;
        }
        .zoom:hover {
            -ms-transform: scale(15); /* IE 9 */
            -webkit-transform: scale(15); /* Safari 3-8 */
            transform: scale(15);
            z-index: 999;
        }

        .borderless td, .borderless th {
            border: none;
        }
        .borderless thead th {
            border: none;
        }

        .table-kecil td, .table-kecil th {
            padding: .1rem;
            padding-top: 0.1rem;
            padding-right: 0.1rem;
            padding-bottom: 0.1rem;
            padding-left: 0.1rem;
        }
    </style>
    <livewire:styles />
    @stack('after-styles')
</head>
<body class="c-app">
    @include('backend.includes.sidebar')

    <div class="c-wrapper c-fixed-components">
        @include('backend.includes.header')
        @include('includes.partials.read-only')
        @include('includes.partials.logged-in-as')
        {{-- @include('includes.partials.announcements') --}}

        <div class="c-body">
            <main class="c-main">
                <div class="container-fluid">
                    <div class="fade-in">
                        @include('includes.partials.messages')
                        @yield('content')
                    </div><!--fade-in-->
                </div><!--container-fluid-->
            </main>
        </div><!--c-body-->

        @include('backend.includes.footer')
    </div><!--c-wrapper-->

    @stack('before-scripts')
    <script src="{{ mix('js/manifest.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
    <script src="{{ mix('js/backend.js') }}"></script>
    <livewire:scripts />
    @stack('after-scripts')
</body>
</html>
