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
                    <span class="welcome-text">{{ __('app.auth.welcome') }}</span>
                    <img src="{{ asset('img/logo.svg') }}" class="welcome-img my-7">
                </div>
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                @if (session('error-email'))
                    <div class="alert alert-danger">
                        {{ session('error-email') }}
                    </div>
                    @php
                        $mama = 0;
                        if(session('user_mama'))
                        {
                            $mama = Str::random(4).session('user_mama');
                        }
                    @endphp
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <input type="text" name="user_mama" value="{{ $mama }}" hidden>
                        <div>
                            <button type="submit" class="mt-3 mb-3 confirm-btn" style="background-color: green">
                                {{ __('app.auth.resend-email') }}
                            </button>
                        </div>
                    </form>
                @endif
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <!-- Email Address -->
                    <div>
                        <x-label for="email" :value="__('app.auth.e-mail')" class="pl-3" />
                        <x-input id="email" class="block mt-1 w-full rounded-3xl" type="email" name="email"
                            :value="old('email')" required />
                    </div>
                    <!-- Password -->
                    <div class="sm:mt-4 mt-2">
                        <x-label for="password" :value="__('app.auth.password')" class="pl-3 text-md" />
                        <x-input id="password" class="block mt-1 w-full rounded-3xl" type="password" name="password"
                            required autocomplete="current-password" />
                    </div>
                    <div class="d-flex align-items-baseline justify-content-between mt-4 form-buttons">
                        <button class="mt-3 confirm-btn">
                            {{ __('app.auth.log-in') }}
                        </button>
                    </div>
                    <div class="flex pl-3 mt-3 justify-center">
                        <span>{{ __('app.auth.dont-have-acc') }}</span>
                        <a href="{{ route('register') }}" class="sing-up pl-1">{{ __('app.auth.sing-up') }}</a>
                    </div>
                    <div class="or-line">
                        <span class="or-text">{{ __('app.auth.or') }}</span>
                    </div>
                    <a href="{{ route('login.google') }}" class="google-btn">
                        {{ __('app.auth.google') }}<i class="ri-google-fill text-2xl pl-2"></i>
                    </a>
                </form>
            </div>
            <div class="log-in-img">

            </div>
        </div>
    </div>
    @if (session('status') == 'Your password has been reset!')
        <script>
            Swal.fire({
                title: "{{ __('app.email.reset-password-success') }}",
                icon: 'success',
                html: "<span>{{ __('app.email.reset-password-success-text') }}</span>",
                showCloseButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            })
        </script>
    @endif
    <style>
        .page-padding {
            padding-top: 0px !important;
        }
    </style>
</x-app-layout>
