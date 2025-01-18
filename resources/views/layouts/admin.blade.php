<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('page-title')</title>
        
        <link rel="icon" type="image/x-icon" href="{{ asset('img/favicon.ico') }}">

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">

        <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    </head>
    @php
        $lang = App::currentLocale();
    @endphp
    <body class="font-sans antialiased">
        <div class="d-flex h-100 mt-150">
            <div class="d-flex side-menu col-2 flex-column admin_menu">
                <div class="py-2 mx-4 border-bottom">
                     <button onclick="LanguageSwitcher('{{ $lang }}')" class="lang-btn-nav"><b>{{ strtoupper($lang) }}</b>
                        <i class="ri-earth-line sm:text-3xl text-2xl"></i>
                    </button>
                </div>
                <div class="py-2 mx-4 border-bottom">
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                </div>
                <div class="py-2 mx-4 border-bottom">
                    <a href="{{ route('admin.users') }}">{{ __('Users') }}</a>
                </div>
                <div class="py-2 mx-4 border-bottom">
                    <a href="{{ route('admin.workers') }}">{{ __('Workers') }}</a>
                </div>
                <div class="py-2 mx-4 border-bottom">
                    <a href="{{ route('admin.categories') }}">{{ __('Categories') }}</a>
                </div>
                <div class="py-2 mx-4 border-bottom">
                    <a href="{{ route('admin.subcategories') }}">{{ __('Subcategories') }}</a>
                </div>
                <div class="py-2 mx-4 border-bottom">
                    <a href="{{ route('admin.pozicija') }}">{{ __('Positions') }}</a>
                </div>
                <div class="alert alert-danger py-2 mx-4 mt-4">
                    <form method="POST" action="{{ route('admin.logout') }}" class="admin-logout">
                        @csrf
                        <a href="{{ route('admin.logout') }}" class=""
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('app.auth.log-out') }}
                        </a>
                        <i class="ri-logout-box-line pl-2 admin-log-out-icon"></i>
                    </form>
                </div>
            </div>
            <div class="d-flex admin-content col-10 p-0 admin_table">
                <main class="w-100">
                    @yield('content')
                </main>
            </div>
        </div>
        <style>
            a:hover {
                text-decoration: none;
                color: white;
            }
        </style>
        <script>
            function LanguageSwitcher(lang) {
                Swal.fire({
                    html: 
                        "@if ($lang == 'sr')<a href='{{ url(Helper::getCurrentUrlWithLocale('sr')) }}' class='disabled-link'>Srpski - latinica</a><br>" +
                        "@else <a href='{{ url(Helper::getCurrentUrlWithLocale('sr')) }}' class='language-name'>Srpski - latinica</a><br> @endif" +

                        "@if ($lang == 'rs-cyrl')<a href='{{ url(Helper::getCurrentUrlWithLocale('rs-cyrl')) }}' class='disabled-link'>Српски - ћирилица</a><br>" +
                        "@else <a href='{{ url(Helper::getCurrentUrlWithLocale('rs-cyrl')) }}' class='language-name'>Српски - ћирилица</a><br> @endif",

                        // "@if ($lang == 'hu')<a href='{{ url(Helper::getCurrentUrlWithLocale('hu')) }}' class='disabled-link'>Magyar</a><br>" +
                        // "@else <a href='{{ url(Helper::getCurrentUrlWithLocale('hu')) }}' class='language-name'>Magyar</a><br> @endif" +

                        // "@if ($lang == 'en')<a href='{{ url(Helper::getCurrentUrlWithLocale('en')) }}' class='disabled-link'>English</a><br>" +
                        // "@else <a href='{{ url(Helper::getCurrentUrlWithLocale('en')) }}' class='language-name' >English</a><br> @endif",
                    showCloseButton: true,
                    showCancelButton: false,
                    showConfirmButton: false,
                })
            }
        </script>
        @include('sweetalert::alert')
    </body>
</html>
