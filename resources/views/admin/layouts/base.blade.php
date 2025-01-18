<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $pageTitle }}</title>

    <!-- Styles -->
    <link rel="icon" type="image/x-icon" href="{{ asset('img/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}"></script>

</head>

<body class="font-sans antialiased">
    <div class="content-height">
        @if ($header != '')
            <!-- Page Content -->
            <div class="header-div">
                <div class="title-div px-5 py-3 sm:px-6 lg:px-12">
                    <span class="mt-36">
                        {{ $header }}
                    </span>
                </div>
            </div>
        @endif

        @if (isset($homePage) && $homePage != '')
            {{ $homePage }}
        @endif

        <main class="page-padding px-4 py-3 sm:px-6 lg:px-12">
            {{ $slot }}
        </main>
    </div>
    @include('sweetalert::alert')
    @php
        \App\Models\Tracker::hit();
    @endphp
    @if (isset($import) && $import != '')
        {{ $import }}
    @endif
</body>
</html>
