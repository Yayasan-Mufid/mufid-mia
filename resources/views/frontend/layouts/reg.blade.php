<!doctype html>
<html lang="{{ htmlLang() }}" @langrtl dir="rtl" @endlangrtl>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ appName() }} | @yield('title')</title>
    <meta name="description" content="@yield('meta_description', appName())">
    <meta name="author" content="@yield('meta_author', 'mufid~asif')">
    <link rel="icon" type="image/x-icon" href="favicon.png">
    @yield('meta')

    @stack('before-styles')
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="{{ mix('css/backend.css') }}" rel="stylesheet">
    <style>
        .card{
            border-radius: 1rem;
        }
    </style>
    @stack('after-styles')
    <script src="{{ mix('js/manifest.js') }}"></script>
    <script src="{{ mix('js/backend.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
</head>
<body>

    <div id="app">
        @include('includes.partials.messages')

        <main>
            @yield('content')
        </main>
    </div><!--app-->

    <script>
        window.addEventListener( "pageshow", function ( event ) {
        var historyTraversal = event.persisted ||
                                ( typeof window.performance != "undefined" &&
                                    window.performance.navigation.type === 2 );
        if ( historyTraversal ) {
            // Handle page restore.
            window.location.reload();
        }
        });
    </script>
</body>
</html>
