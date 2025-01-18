<x-guest-layout>
    <x-slot name="logo">
    </x-slot>
    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors" />
    <div class="win-height">
        <div class="log-in-container py-6 pb-14">
            <div class="log-in-form py-8">
                <div class="log-in-welcome">
                    <span class="welcome-text">{{ __('app.email.reset-password') }}</span>
                    <img src="{{ asset('img/logo.svg') }}" class="welcome-img my-7">
                </div>
            </div>
            <div class="verify-email flex items-center justify-center flex-col ">
                <div class="flex verify-btns mt-4">
                    <form method="POST" action="{{ route('password.update') }}" class="w-full">
                        @csrf
                        <!-- Password Reset Token -->
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">
                        <!-- Email Address -->
                        {{ $request->route('token') }}
                        <div>
                            <x-label for="email" :value="__('Email')" class="pl-3"/>
                            <x-input id="email" class="block mt-1 w-full rounded-3xl" type="email" name="email" :value="old('email', $request->email)" required autofocus />
                        </div>
                        <!-- Password -->
                        <div class="mt-4">
                            <x-label for="password" :value="__('Password')" class="pl-3"/>
                            <x-input id="password" class="block mt-1 w-full rounded-3xl" type="password" name="password" required />
                        </div>
                        <!-- Confirm Password -->
                        <div class="mt-4">
                            <x-label for="password_confirmation" :value="__('Confirm Password')" class="pl-3"/>
                            <x-input id="password_confirmation" class="block mt-1 w-full rounded-3xl"
                                                type="password"
                                                name="password_confirmation" required />
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <button class="mt-3 confirm-btn">
                                {{ __('app.email.reset-password') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @if (session('status'))
        <script>
            Swal.fire({
                title: "{{ __('app.auth.e-mail-sent') }}",
                icon: 'success',
                html: "<span>{{ __('app.email.forgot password-swal-text') }}</span>",
                showCloseButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            })
        </script>
    @endif
</x-guest-layout>
<style>
    body {
        background: linear-gradient(-45deg, #164E99, #72afff);
        animation: gradient 5s ease infinite;
        background-size: 400% 400%;
        height: 100vh;
    }

    @keyframes gradient {
        0% {
            background-position: 0% 50%
        }

        50% {
            background-position: 100% 50%
        }

        100% {
            background-position: 0% 50%
        }
    }

    .verify-email {
        border-top-right-radius: 35px;
        border-bottom-right-radius: 35px;
        width: 45%;
    }

    .welcome-text {
        text-transform: uppercase;
    }

    .verify-btns {
        justify-content: space-between;
        width: 80%;
    }

    .log-out-btn {
        color: black;
        font-size: 18px;
        border: 1px solid black;
        font-weight: 700;
        padding: 10px 30px 10px 30px;
        border-radius: 25px;
        height: 50px;
        width: 100%;
    }

    @media (max-width: 1580px) {
        .verify-btns {
            justify-content: center !important;
            flex-direction: column;
            width: 80%;
        }
    }

    @media (max-width: 1100px) {
        .log-in-form {
            width: 50% !important;
        }

        .verify-email {
            width: 50% !important;
        }
    }

    .confirm-btn {
        font-size: 18px !important;
    }

    @media (max-width: 765px) {
        .log-in-container {
            flex-direction: column !important;
            margin-bottom: 20px;
            margin-top: 20px;
        }

        .verify-email {
            width: 100% !important;
        }
        .log-in-form {
            width: 100% !important;
        }

        .confirm-btn {
            height: fit-content !important;
        }

        .win-height {
            height: 115% !important;
        }
    }
</style>

{{-- <x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>
        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        
    </x-auth-card>
</x-guest-layout> --}}
