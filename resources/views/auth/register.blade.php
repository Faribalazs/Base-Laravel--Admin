<x-app-layout>
    <x-slot name="pageTitle">
        {{ __('app.auth.log-in') }}
    </x-slot>
    <x-slot name="header">
    </x-slot>
    <x-auth-validation-errors class="mb-4" :errors="$errors" />
    <div class="win-height">
        <div class="log-in-container">
            <div class="log-in-form py-8">
                <div class="log-in-welcome">
                    <span class="welcome-text">{{ __('app.auth.welcome-register') }}</span>
                    <img src="{{ asset('img/logo.svg') }}" class="welcome-img my-7">
                </div>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <input type="hidden" value="user" name="role_id">
                    <!-- Name -->
                    <div class="mt-3">
                        <x-label for="name" :value="__('app.auth.name')" class="pl-3"/>
                        <x-input id="name" class="block mt-1 w-full rounded-3xl" type="text" name="name"
                            :value="old('name')" required autofocus />
                    </div>
                    <!-- Email Address -->
                    <div class="mt-3">
                        <x-label for="email" :value="__('app.auth.e-mail')" class="pl-3" />
                        <x-input id="email" class="block mt-1 w-full rounded-3xl" type="email" name="email"
                            :value="old('email')" required />
                    </div>
                    <!-- Password -->
                    <div class="mt-3">
                        <x-label for="password" :value="__('app.auth.password')" class="pl-3 text-md" />
                        <x-input id="password" class="block mt-1 w-full rounded-3xl" type="password" name="password"
                            required autocomplete="current-password" />
                    </div>
                    <!-- Confirm Password -->
                    <div class="mt-3">
                        <x-label for="password_confirmation" :value="__('app.auth.conf-password')" class="pl-3"/>
                        <x-input id="password_confirmation" class="block mt-1 w-full rounded-3xl" type="password"
                            name="password_confirmation" required />
                    </div>
                    <div class="d-flex align-items-baseline justify-content-between mt-4 form-buttons">
                        <button class="mt-3 confirm-btn">
                            {{ __('app.auth.register-btn') }}
                        </button>
                    </div>
                    <div class="flex pl-3 mt-3 justify-center">
                        <span>{{ __('app.auth.have-acc') }}</span>
                        <a class="sing-up pl-1" href="{{ route('login') }}">
                            {{ __('app.auth.log-in-text') }}
                        </a>
                    </div>
                    <div class="or-line">
                        <span class="or-text">{{ __('app.auth.or') }}</span>
                    </div>
                    <a href="{{ route('login.google') }}" class="google-btn">
                        {{ __('app.auth.google') }}<i class="ri-google-fill text-2xl pl-2"></i>
                    </a>
                </form>
            </div>
            {{-- <div class="log-in-img">
            </div> --}}
        </div>
    </div>
    <style>
        .page-padding {
            padding-top: 0px !important;
        }
        
        .log-in-form {
            width: 75%
        }

        .confirm-btn {
            width: 60%;
            margin: auto;
        }

        .google-btn {
            width: 60%;
            margin: auto;
        }

        .win-height {
            height: 115vh;
        }

        @media (max-width: 640px) {
            .confirm-btn {
            width: 100% !important;
        }

        .google-btn {
            width: 100% !important;
        }
        }

    </style>
</x-app-layout>
