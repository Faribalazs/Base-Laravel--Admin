<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $pageTitle }}</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('img/favicon.ico') }}">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
</head>

@php
    $lang = App::currentLocale();
@endphp

<body class="font-sans antialiased">
    <div class="min-h-screen">
        <!-- Page Content -->
        <main class="admin-page-padding">
            <div class="profile-nav-bg"></div>
            <div class="flex overflow-hidden flex-nowrap justify-between">
                <div class="profile-side-panel w-14">
                    <div class="menu-btn">
                        <div class="line line--1"></div>
                        <div class="line line--2"></div>
                        <div class="line line--3"></div>
                    </div>
                    <div class="closed-links">
                        <a href="{{ route('admin.dashboard') }}"
                            class="icons {{ request()->routeIs('admin.dashboard') ? 'closed-icon-active' : '' }}">
                            <i class="ri-home-4-line"></i>
                        </a>
                        <a href="{{ route('admin.users') }}"
                            class="icons {{ request()->routeIs('admin.users') ? 'closed-icon-active' : '' }}">
                            <i class="ri-group-line"></i>
                        </a>
                        <a href="{{ route('admin.workers') }}"
                            class="icons 
                            {{ request()->routeIs('admin.workers') ? 'closed-icon-active' : '' }}">
                            <i class="ri-group-fill"></i>
                        </a>
                        <a href="{{ route('admin.workers.with.premium') }}"
                            class="icons 
                            {{ request()->routeIs('admin.workers.with.premium') ? 'closed-icon-active' : '' }}">
                            <i class="ri-group-fill"></i>
                        </a>
                        <a href="{{ route('admin.categories') }}"
                            class="icons 
                            {{ request()->routeIs('admin.categories') ? 'closed-icon-active' : '' }}">
                            <i class="ri-function-line"></i>
                        </a>
                        <a href="{{ route('admin.subcategories') }}"
                            class="icons 
                            {{ request()->routeIs('admin.subcategories') ? 'closed-icon-active' : '' }}">
                            <i class="ri-dashboard-line"></i>
                        </a>
                        <a href="{{ route('admin.pozicija') }}"
                            class="icons 
                            {{ request()->routeIs('admin.pozicija') ? 'closed-icon-active' : '' }}">
                            <i class="ri-menu-2-line"></i>
                        </a>
                        <a href="{{ route('admin.sections.create') }}"
                            class="icons 
                            {{ request()->routeIs('admin.sections.create') ? 'closed-icon-active' : '' }}">
                            <i class="ri-draft-line"></i>
                        </a>
                        <form method="POST" id="log-out-form" action="{{ route('admin.logout') }}"
                            class="admin-logout icons">
                            @csrf
                            <button type="button" onclick="logOut()"><i class="ri-logout-box-r-line"></i></button>
                        </form>
                    </div>
                    <div class="nav-links">
                        <a href="{{ route('admin.dashboard') }}" class="link">
                            {{ __('app.admin.dashboard') }}
                        </a>
                        <a href="{{ route('admin.users') }}" class="link">
                            {{ __('app.admin.users') }}
                        </a>
                        <a href="{{ route('admin.workers') }}" class="link">
                            {{ __('app.admin.workers') }}
                        </a>
                        <a href="{{ route('admin.workers.with.premium') }}" class="link">
                            {{ __('app.admin.workers-with-premium') }}
                        </a>
                        <a href="{{ route('admin.categories') }}" class="link">
                            {{ __('app.admin.categories') }}
                        </a>
                        <a href="{{ route('admin.subcategories') }}" class="link">
                            {{ __('app.admin.subcategories') }}
                        </a>
                        <a href="{{ route('admin.pozicija') }}" class="link">
                            {{ __('app.admin.pozicije') }}
                        </a>
                        <a href="{{ route('admin.sections.create') }}" class="link">
                            {{ __('app.admin.sections') }}
                        </a>
                        <a onclick="logOut()" class="link cursor-pointer">
                            {{ __('app.profile.log-out') }}
                        </a>
                    </div>
                </div>
                <div class="content-side">
                    <div class="flex profile-title justify-between items-center">
                        <div class="text-3xl font-bold">{{ $header }} :</div>
                        <button onclick="LanguageSwitcher('{{ $lang }}')"
                            class="flex items-center justify-center sm:text-xl pr-3 text-lg">
                            <i class="ri-earth-line sm:text-3xl pr-3 text-2xl"></i>

                            @if ( strtoupper($lang) == "SR")
                                <b>Srpski - latinica</b>
                            @elseif (strtoupper($lang) == "RS-CYRL")
                                <b>Српски - ћирилица</b>
                            @endif

                        </button>
                    </div>
                    {{ $slot }}
                </div>
            </div>
        </main>
    </div>
    @include('sweetalert::alert')
</body>
<script>
    var menuBtn = document.querySelector('.menu-btn');
    var content = document.querySelector('.content-side');
    var navBg = document.querySelector('.profile-nav-bg');
    var navPanel = document.querySelector('.profile-side-panel');
    var lineOne = document.querySelector('.profile-side-panel .menu-btn .line--1');
    var lineTwo = document.querySelector('.profile-side-panel .menu-btn .line--2');
    var lineThree = document.querySelector('.profile-side-panel .menu-btn .line--3');
    var link = document.querySelector('.profile-side-panel .nav-links');
    menuBtn.addEventListener('click', () => {
        navPanel.classList.toggle('nav-open');
        lineOne.classList.toggle('line-cross');
        lineTwo.classList.toggle('line-fade-out');
        lineThree.classList.toggle('line-cross');
        link.classList.toggle('fade-in');
        navBg.classList.toggle('profile-nav-open');
        content.classList.toggle('content-open');
    })

    function logOut() {
        Swal.fire({
            title: '{{ __('app.profile.log-out-ask') }}?',
            showCancelButton: true,
            icon: 'question',
            confirmButtonText: '{{ __('app.profile.yes') }}',
            showCloseButton: true,
            confirmButtonColor: '#ac1902',
            cancelButtonText: '{{ __('app.profile.no') }}',
        }).then((result) => {
            if (result.isConfirmed) {
                document.querySelector('#log-out-form').submit();
            }
        })
    }

    function LanguageSwitcher(lang) {
        Swal.fire({
            html: "@if ($lang == 'sr')<a href='{{ url(Helper::getCurrentUrlWithLocale('sr')) }}' class='disabled-link'>Srpski - latinica</a><br>" +
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
<style>
    .profile-side-panel {
        min-height: 45.125rem !important;
    }

    .profile-side-panel {
        position: fixed !important;
    }

    .content-side {
        margin-left: auto;
        transition: all 800ms cubic-bezier(0.8, 0, 0.33, 1);
    }

    .content-open {
        width: calc(100% - 322px) !important;
        min-width: calc(100% - 322px) !important;
        margin-left: auto;
        transition: all 800ms cubic-bezier(0.8, 0, 0.33, 1);
    }

    .icons,
    .icons:hover {
        text-decoration: none !important;
    }

    .language-name,
    .language-name:hover,
    .disabled-link,
    .disabled-link:hover {
        text-decoration: none !important;
    }
</style>

</html>
