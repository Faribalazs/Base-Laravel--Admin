<x-app-layout>
    <x-slot name="pageTitle">
        {{ __('app.auth.register-btn') }}
    </x-slot>

    <x-slot name="header">
        {{ __('app.auth.register-btn') }}
    </x-slot>

    <div class="mt-20 lg:w-1/2 md:w-3/4 mx-auto">
        <form method="POST" action="{{ route('worker.register') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="user" name="role_id">

            <!-- First name -->
            <div class="mt-4">
                <x-label for="first_name" :value="__('app.auth.name').' *'" class="pb-1 pl-1 input-label" />
                <x-input id="name" class="input-style w-full" type="text" name="first_name" :value="old('first_name')"
                    required autofocus />
                <p class="{{ $errors->has('first_name') ? 'flex text-red mt-2 pl-1' : 'hidden' }}">
                    {{ $errors->first('first_name') }}
                </p>
            </div>

            <!-- Last name -->
            <div class="mt-4">
                <x-label for="last_name" :value="__('app.auth.last-name').' *'" class="pb-1 pl-1 input-label" />
                <x-input id="name" class="input-style w-full" type="text" name="last_name" :value="old('last_name')"
                    required autofocus />
                <p class="{{ $errors->has('last_name') ? 'flex text-red mt-2 pl-1' : 'hidden' }}">
                    {{ $errors->first('last_name') }}
                </p>
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('app.auth.e-mail').' *'" class="pb-1 pl-1 input-label" />
                <x-input id="email" class="input-style w-full" type="email" name="email" :value="old('email')"
                    required />
                <p class="{{ $errors->has('email') ? 'flex text-red mt-2 pl-1' : 'hidden' }}">
                    {{ $errors->first('email') }}
                </p>
            </div>

            <!-- Password -->
            <div class="mt-4 relative">
                <x-label for="password" :value="__('app.auth.password').' *'" class="pb-1 pl-1 input-label" />
                <x-input id="password" class="input-style w-full" type="password" name="password" required
                    autocomplete="current-password" />
                <i id="eye_icon_pass" onclick="showHidePassword()" class="ri-eye-line eye-icon"></i>
            </div>
            <p class="{{ $errors->has('password') ? 'flex text-red mt-2 pl-1' : 'hidden' }}">
                {{ $errors->first('password') }}
            </p>

            <!-- Confirm Password -->
            <div class="mt-4 relative">
                <x-label for="password_confirmation" :value="__('app.auth.conf-password').' *'" class="pb-1 pl-1 input-label" />
                <x-input id="password_confirmation" class="input-style w-full" type="password"
                    name="password_confirmation" required />
                <i id="eye_icon_conf_pass" onclick="showHideConfirmPassword()" class="ri-eye-line eye-icon"></i>
            </div>
            <p class="{{ $errors->has('password_confirmation') ? 'flex text-red mt-2 pl-1' : 'hidden' }}">
                {{ $errors->first('password_confirmation') }}
            </p>

            <!-- Phone -->
            <div class="mt-4">
                <x-label for="phone" :value="__('app.auth.phone-number')" class="pb-1 pl-1 input-label" />
                <x-input id="phone" :value="old('phone')" class="input-style w-full" type="text" name="phone" />
                <p class="{{ $errors->has('phone') ? 'flex text-red mt-2 pl-1' : 'hidden' }}">
                    {{ $errors->first('phone') }}
                </p>
            </div>

            <!-- CV -->
            <div class="mt-4">
                <x-label for="cv" :value="__('app.auth.o-mojstoru')" class="pb-1 pl-1 input-label" />
                <textarea name="cv" rows="4" class="input-style w-full">{{ old('cv') }}</textarea>
                <p class="{{ $errors->has('cv') ? 'flex text-red mt-2 pl-1' : 'hidden' }}">
                    {{ $errors->first('cv') }}
                </p>
            </div>

            <!-- Profile Image -->
            <x-label for="user_image" :value="__('app.auth.profile-pics')" class="pb-1 pl-1 input-label mt-4" />
            <div class="flex flex-col sm:flex-row">
                <label for="file-upload" class="image-upload-btn px-4 py-3 cursor-pointer text-center">
                    {{ __('app.profile.choose-image') }}
                </label>
                <input id="file-upload" name="user_image" type="file" style="display:none;">
                <input id="uploadFile" class="text-center sm:text-left sm:pl-3 pl-0 sm:mt-0 mt-2 max-w-full"
                    placeholder="{{ __('app.profile.no-img-selected') }}" disabled="disabled" />
            </div>
            <p class="{{ $errors->has('user_image') ? 'flex text-red mt-2 pl-1' : 'hidden' }}">
                {{ $errors->first('user_image') }}</p>

            <!-- Submit Button -->
            <div class="flex justify-center mt-24 form-buttons">
                <button class="mt-3 confirm-btn">
                    {{ __('app.auth.register-btn') }}
                </button>
            </div>

            <div class="flex pl-3 mt-3 justify-center text-lg">
                <span>{{ __('app.auth.have-acc') }}</span>
                <a class="sing-up pl-1" href="{{ route('login') }}">
                    {{ __('app.auth.log-in-text') }}
                </a>
            </div>
            <div class="or-line">
                <span class="or-text">{{ __('app.auth.or') }}</span>
            </div>
            <a href="{{ route('worker.login.google') }}" class="google-btn">
                {{ __('app.auth.google') }}<i class="ri-google-fill text-2xl pl-2"></i>
            </a>
        </form>
    </div>

    <script>
        document.getElementById("file-upload").onchange = function() {
            document.getElementById("uploadFile").value = this.value.replace('C:\\fakepath\\', ' ');
        };

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

        function showHideConfirmPassword() {
            var input = document.getElementById("password_confirmation");
            var eyeIcon = document.getElementById("eye_icon_conf_pass");

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

        .eye-icon {
            position: absolute;
            right: 11px;
            bottom: 5px;
            font-size: 21px;
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
