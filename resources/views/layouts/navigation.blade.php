@php
    $lang = App::currentLocale();
@endphp
<div class="nav xl:hidden">
    <div class="nav__content">
        <div class="nav__list px-4 gap-4">
            <div class="nav__list-item mt-32 text-center">
                @if (Auth::guard('worker')->check())
                    @if (Auth::guard('worker')->user()->hasRole('worker') || Auth::guard('worker')->user()->hasRole('super_worker'))
                        <div class=" font-bold py-3 text-2xl space-x-8 sm:-my-px sm:ml-10 xl:flex items-center">
                            <x-nav-link :href="route('worker.catalogue-categories')" :active="request()->routeIs('worker.catalogue-categories')">
                                {{ __('app.categories.catalogue-categories') }}
                            </x-nav-link>
                        </div>
                    @endif
                @endif
                @if (Auth::guard('worker')->check())
                    @if (Auth::guard('worker')->user()->hasRole('worker') || Auth::guard('worker')->user()->hasRole('super_worker'))
                        <div class=" font-bold py-3 text-2xl space-x-8 sm:-my-px sm:ml-10 xl:flex items-center">
                            <x-nav-link :href="route('worker.new.ponuda')" :active="request()->routeIs('worker.new.ponuda')">
                                {{ __('app.nav.new-ponuda') }}
                            </x-nav-link>
                        </div>
                    @endif
                @endif
                @if (Auth::guard('worker')->check())
                    @if (Auth::guard('worker')->user()->hasRole('worker') || Auth::guard('worker')->user()->hasRole('super_worker'))
                        <div class=" text-2xl font-bold py-3 space-x-8 sm:-my-px sm:ml-10 xl:flex items-center">
                            <x-nav-link :href="route('worker.options.update')" :active="request()->routeIs('worker.my-categories*')">
                                {{ __('app.nav.my-categories') }}
                            </x-nav-link>
                        </div>
                    @endif
                @endif
                @if (Auth::guard('worker')->check())
                    @if (Auth::guard('worker')->user()->hasRole('worker') || Auth::guard('worker')->user()->hasRole('super_worker'))
                        <div class=" text-2xl font-bold py-3 space-x-8 sm:-my-px sm:ml-10 xl:flex items-center">
                            <x-nav-link :href="route('worker.archive')" :active="request()->routeIs('worker.archive*')">
                                {{ __('app.nav.archive') }}
                            </x-nav-link>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
<nav x-data="{ open: false }" id="nav" class="nav-max">
    <!-- Primary Navigation Menu -->
    <div class="px-4 py-3 sm:px-6 lg:px-12 h-100 align-items-center nav-div">
        <div class="flex justify-between h-100 nav-items">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center z-50">
                <a href="{{ route('home') }}">
                    <x-application-logo class="block h-10 w-auto fill-current text-gray-600" />
                </a>
            </div>

            <!-- Navigation Links -->
            @if (Auth::user())
                @if (Auth::user()->hasRole('user'))
                    <div class="hidden space-x-8 sm:-my-px xl:flex items-center">
                        <x-nav-link :href="route('myprofile')" :active="request()->routeIs('myprofile')">
                            {{ __('My Profile') }}
                        </x-nav-link>
                    </div>
                @endif
            @endif

            <!-- Settings Dropdown -->
            <div class="hidden xl:flex xl:items-center xl:ml-6 space-x-5">
                <button onclick="LanguageSwitcher('{{ $lang }}')"
                    title="{{ __('app.basic.choose-language') }}">
                    <i class="ri-earth-line sm:text-3xl text-2xl"></i>
                </button>
                @if (!Auth::user() && !Auth::guard('worker')->check() && !Auth::guard('admin')->check())
                    <a href="{{ route('worker.session.create') }}">
                        <i class="ri-user-3-line sm:text-3xl text-2xl"></i>
                    </a>
                @endif
                @if (Auth::user())
                    @if (Auth::user()->hasRole('user'))
                        @php
                            $logInCircle = mb_substr(Auth::user()->name, 0, 1);
                        @endphp
                        <div class="flex gap-1">
                            <div class="flex justify-center items-center">
                                <a href="{{ route('myprofile') }}">{{ Auth::user()->name }}</a>
                                <i class="ri-user-3-line sm:text-3xl text-2xl pl-2"></i>
                            </div>
                        </div>
                    @endif
                @endif
                @if (Auth::guard('worker')->user())
                    @php
                        $logInCircle = mb_substr(Auth::guard('worker')->user()->name, 0, 1);
                    @endphp
                    <div class="flex gap-1">
                        <div class="flex justify-center items-center">
                            <a href="{{ route('worker.myprofile') }}" class="flex profile-btn items-center">
                                {{ Auth::guard('worker')->user()->first_name }}
                                <i class="ri-user-3-line sm:text-3xl text-2xl pl-2"></i>
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Hamburger -->
            <div class="flex items-center xl:hidden gap-4" style="margin-top:8px;">
                <button onclick="LanguageSwitcher('{{ $lang }}')" class="lang-btn-nav"
                    title="{{ __('app.basic.choose-language') }}">
                    <i class="ri-earth-line sm:text-3xl text-2xl"></i>
                </button>
                @if (!Auth::guard('worker')->user())
                    <a href="{{ route('worker.session.create') }}" class="log-in-btn-nav">
                        <i class="ri-user-3-line sm:text-3xl text-2xl"></i>
                    </a>
                @elseif(Auth::guard('worker')->user())
                    <a href="{{ route('worker.myprofile') }}" class="log-in-btn-nav">
                        <i class="ri-user-3-line sm:text-3xl text-2xl"></i>
                    </a>
                @endif
                <div class="menu-icon">
                    <span class="menu-icon__line menu-icon__line-left"></span>
                    <span class="menu-icon__line"></span>
                    <span class="menu-icon__line menu-icon__line-right"></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden xl:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        @if (Auth::user())
            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="flex items-center px-4">
                    <div class="flex-shrink-0">
                        <svg class="h-10 w-10 fill-current text-gray-400" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>

                    <div class="ml-3">
                        <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Logout') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @endif
    </div>
</nav>
<script>
    setTimeout(() => {
        let body;
        let menu;
        let menuItems;

        const init = () => {
            body = document.querySelector('body');
            menu = document.querySelector('.menu-icon');
            nav = document.querySelector('.nav');
            navmax = document.querySelector('.nav-max');
            menuItems = document.querySelectorAll('.nav__list-item');
            applyListeners();
        }
        const applyListeners = () => {
            menu.addEventListener('click', () => toggleClass(body, 'nav-active'));
            menu.addEventListener('click', () => toggleClass(nav, 'nav-index'));
            menu.addEventListener('click', () => toggleClass(navmax, 'nav-shadow'));
            menu.addEventListener('click', () => toggleClass(body, 'pf'));
        }
        const toggleClass = (element, stringClass) => {
            if (element.classList.contains(stringClass))
                element.classList.remove(stringClass);
            else
                element.classList.add(stringClass);
        }
        init();
        var navbar = document.getElementById("nav");
    }, 10);

    function LanguageSwitcher(lang) {
        Swal.fire({
            html: "<span class='language-title-swall md:text-4xl text-3xl'>{{ __('app.basic.choose-language') }}</span><br>" +
                "@if ($lang == 'sr')<a href='{{ url(Helper::getCurrentUrlWithLocale('sr')) }}' class='disabled-link block md:text-2xl text-xl mt-2'>Srpski - latinica</a><br>" +
                "@else <a href='{{ url(Helper::getCurrentUrlWithLocale('sr')) }}' class='language-name block md:text-2xl text-xl mt-2'>Srpski - latinica</a><br> @endif" +

                "@if ($lang == 'rs-cyrl')<a href='{{ url(Helper::getCurrentUrlWithLocale('rs-cyrl')) }}' class='disabled-link md:text-2xl text-xl'>Српски - ћирилица</a><br>" +
                "@else <a href='{{ url(Helper::getCurrentUrlWithLocale('rs-cyrl')) }}' class='language-name md:text-2xl text-xl'>Српски - ћирилица</a><br> @endif",

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
    .profile-circle {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        font-weight: 700;
        font-size: 15px;
        display: flex;
        justify-content: center;
        align-items: center;
        color: white;
        margin-left: 5px;
        background-color: #0d2c5a;
    }

    .sticky {
        position: sticky !important;
    }
</style>
