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

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</head>

<body class="font-sans antialiased">
    <div class="profile-page-min-height">
        @include('layouts.navigation')

        <!-- Page Content -->
        <main class="page-padding-profile">
            <div class="profile-nav-bg"></div>
            <div class="flex overflow-hidden flex-nowrap justify-between">
                <div class="profile-side-panel w-14">
                    <div class="menu-btn">
                        <div class="line line--1"></div>
                        <div class="line line--2"></div>
                        <div class="line line--3"></div>
                    </div>
                    <div class="closed-links">
                        <a href="{{ route('worker.myprofile') }}"
                            class="icons {{ request()->routeIs('worker.myprofile') ? 'closed-icon-active' : '' }}">
                            <i class="ri-user-3-line"></i>
                        </a>
                        <a href="{{ route('worker.personal.data') }}"
                            class="icons {{ request()->routeIs('worker.personal.data') ? 'closed-icon-active' : '' }}">
                            <i class="ri-pass-valid-line"></i>
                        </a>
                        <a href="{{ route('worker.personal.contacts') }}"
                            class="icons 
                            {{ request()->routeIs('worker.personal.contacts*') ? 'closed-icon-active' : '' }}">
                            <i class="ri-contacts-line"></i>
                        </a>
                        <a href="{{ route('worker.personal.account.settings') }}"
                            class="icons 
                            {{ request()->routeIs('worker.personal.account.settings') ? 'closed-icon-active' : '' }}">
                            <i class="ri-settings-3-line"></i>
                        </a>
                        <form method="POST" id="log-out-form" action="{{ route('worker.logout') }}" class="icons">
                            @csrf
                            <button type="button" onclick="logOut()"><i class="ri-logout-box-r-line"></i></button>
                        </form>
                    </div>
                    <div class="nav-links">
                        <a href="{{ route('worker.myprofile') }}" class="link">
                            {{ __("app.profile.my-account") }}
                        </a>
                        <a href="{{ route('worker.personal.data') }}" class="link">
                            {{ __("app.profile.company-data") }}
                        </a>
                        <a href="{{ route('worker.personal.contacts') }}" class="link">
                            {{ __("app.profile.my-clients") }}
                        </a>
                        <a href="{{ route('worker.personal.account.settings') }}" class="link">
                            {{ __("app.profile.settings") }}
                        </a>
                        <a onclick="logOut()" class="link cursor-pointer">
                            {{ __("app.profile.log-out") }}
                        </a>
                    </div>
                </div>
                <div class="content-side">
                    {{ $slot }}
                </div>
            </div>
        </main>
    </div>
    @include('worker.layouts.footer')
    @include('sweetalert::alert')
</body>
<script>
    var menuBtn = document.querySelector('.menu-btn');
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
    })

    function logOut() {
        Swal.fire({
            title: '{{ __("app.profile.log-out-ask") }}?',
            showCancelButton: true,
            icon: 'question',
            confirmButtonText: '{{ __("app.profile.yes") }}',
            showCloseButton: true,
            confirmButtonColor: '#ac1902',
            cancelButtonText: '{{ __("app.profile.no") }}',
        }).then((result) => {
            if (result.isConfirmed) {
                document.querySelector('#log-out-form').submit();
            }
        })
    }
</script>
<style>
    .footer-bg {
        margin-top: 0px !important;
    }
</style>

</html>
