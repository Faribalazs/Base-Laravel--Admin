<x-app-layout>
    <x-slot name="pageTitle">
        {{ __('app.auth.log-in') }}
    </x-slot>
    <x-slot name="header">
        {{ __('app.auth.log-in') }}
    </x-slot>
    <x-auth-validation-errors class="mb-4" :errors="$errors" />
    <div class="mt-20 lg:w-1/2 md:w-3/4 mx-auto">
        <form method="POST" action="{{ route('worker.session.create') }}">
            @csrf
            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('app.auth.e-mail')" class="pb-1 pl-1 input-label" />
                <x-input id="email" class="input-style w-full" type="email" name="email" :value="old('email')"
                    required />
            </div>
            <!-- Password -->
            <div class="sm:mt-4 mt-2 relative">
                <x-label for="password" :value="__('app.auth.password')" class="pb-1 pl-1 input-label" />
                <x-input id="password" class="input-style w-full" type="password" name="password" required
                    autocomplete="current-password" />
                <i id="eye_icon_pass" onclick="showHidePassword()" class="ri-eye-line eye-icon"></i>
            </div>
            <div class="d-flex align-items-baseline justify-content-between mt-4 form-buttons">
                <button class="mt-3 confirm-btn">
                    {{ __('app.auth.log-in') }}
                </button>
            </div>
            <div class="flex pl-3 mt-4 justify-center text-lg">
                <span>{{ __('app.auth.dont-have-acc') }}</span>
                <a href="{{ route('worker.register') }}" class="sing-up pl-1">{{ __('app.auth.sing-up') }}</a>
            </div>
            <div class="or-line">
                <span class="or-text">{{ __('app.auth.or') }}</span>
            </div>
            <a href="{{ route('worker.login.google') }}" class="google-btn">
                {{ __('app.auth.google') }}<i class="ri-google-fill text-2xl pl-2"></i>
            </a>
        </form>
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

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if (session('error-email'))
        @php
            $mama = 0;
            if (session('mama')) {
                $mama = Str::random(4) . session('mama');
            }
        @endphp

        <script>
            Swal.fire({
                title: "{{ __('app.email.verify-email') }}",
                icon: 'warning',
                html: '<form method="POST" action="{{ route('worker.verification.send') }}">' +
                    '@csrf' +
                    '<input type="text" name="mama" value="{{ $mama }}" hidden>' +
                    '<div>' +
                    '<button type="submit" class="mt-3 mb-3 confirm-btn">' +
                    '{{ __('app.auth.resend-email') }}' +
                    '</button>' +
                    '</div>' +
                    '</form>',
                showCloseButton: true,
                showConfirmButton: false,
            })
        </script>
    @endif

    <script>
        function showHidePassword() {
            var input = document.getElementById("password");
            var eyeIcon = document.getElementById("eye_icon_pass");

            if (input.type === "password") {
                input.type = "text";
                eyeIcon.classList.remove('ri-eye-line');
                eyeIcon.classList.add('ri-eye-off-line');

            } else {
                input.type = "password";
                eyeIcon.classList.remove('ri-eye-off-line');
                eyeIcon.classList.add('ri-eye-line');
            }
        }
    </script>

    <style>
        .page-padding {
            padding-top: 0px !important;
        }

        .eye-icon {
            position: absolute;
            right: 11px;
            bottom: 5px;
            font-size: 21px;
        }

    </style>
</x-app-layout>
