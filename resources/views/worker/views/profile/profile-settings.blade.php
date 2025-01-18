<x-worker-profile-layout>
    <x-slot name="pageTitle">
        {{ __('app.profile.settings') }}
    </x-slot>
    <x-slot name="header">
    </x-slot>
    <div class="flex profile-title">
        <p class="text-3xl font-bold">{{ __('app.profile.settings') }} :</p>
    </div>
    <div class="flex mt-3 flex-col">
        <p class="text-2xl font-bold mt-5">{{ __('app.profile.change-password') }} :</p>
        <form action="{{ route('worker.personal.account.settings.update-password') }}" method="POST">
            @csrf
            <div class="flex flex-col">
                <label for="old_password" class="sm:text-xl text-base my-3">{{ __('app.profile.old-password') }}
                    :</label>
                <input class="input-style {{ $errors->has('old_password') ? 'border-error mb-1' : 'mb-3' }}"
                    name="old_password" type="password" placeholder="{{ __('app.profile.old-password') }}" required>
                <p class="{{ $errors->has('old_password') ? 'flex text-red mt-1 pl-1' : 'hidden' }}">
                    {{ $errors->first('old_password') }}</p>
            </div>
            <div class="flex flex-col">
                <label for="newPasswordInput" class="sm:text-xl text-base my-3">{{ __('app.profile.new-password') }}
                    :</label>
                <input name="new_password" type="password"
                    class="input-style {{ $errors->has('new_password') ? 'border-error mb-1' : 'mb-3' }}"
                    id="newPasswordInput" placeholder="{{ __('app.profile.new-password') }}" required>
                <p class="{{ $errors->has('new_password') ? 'flex text-red mt-1 pl-1' : 'hidden' }}">
                    {{ $errors->first('new_password') }}</p>
            </div>
            <div class="flex flex-col">
                <label for="confirmNewPasswordInput"
                    class="sm:text-xl text-base my-3">{{ __('app.profile.confirm-new-password') }} :</label>
                <input name="new_password_confirmation" type="password" class="input-style" id="confirmNewPasswordInput"
                    placeholder="{{ __('app.profile.confirm-new-password') }}" required>
            </div>
            <button class="add-new-contact-btn flex rounded-md text-xl justify-center mt-10 w-2/4 py-2 mx-auto"
                type="submit">{{ __('app.profile.change') }}</button>
        </form>
    </div>

    <div class="flex my-20 flex-col">
        <p class="text-2xl font-bold mt-5 mb-5">{{ __('app.profile.email-messages') }} :</p>
        <form action="{{ route('worker.myprofile.send.email') }}" method="POST">
            @csrf
            @method('PUT')
            <div>
                <label class="sm:text-xl text-base my-3">{{ __('app.profile.send-email-on-download') }}:</label>
                <div class="flex mt-5">
                    <div class="mr-20">
                        <input type="radio" id="skini_no" name="skini" value="1"
                            @if (!auth('worker')->user()->send_email_on_download) {{ 'checked' }} @endif />
                        <label for="skini_no">{{ __('app.profile.no') }}</label>
                    </div>
                    <div>
                        <input type="radio" id="skini_yes" name="skini" value="2"
                            @if (auth('worker')->user()->send_email_on_download) {{ 'checked' }} @endif />
                        <label for="skini_yes">{{ __('app.profile.yes') }}</label>
                    </div>
                </div>
            </div>

            <div class="mt-10">
                <label class="sm:text-xl text-base my-3">{{ __('app.profile.send-email-on-send') }}:</label>
                <div class="flex mt-5">
                    <div class="mr-20">
                        <input type="radio" id="posalji_no" name="posalji" value="1"
                            @if (!auth('worker')->user()->send_email_on_send) {{ 'checked' }} @endif />
                        <label for="posalji_no">{{ __('app.profile.no') }}</label>
                    </div>
                    <div>
                        <input type="radio" id="posalji_yes" name="posalji" value="2"
                            @if (auth('worker')->user()->send_email_on_send) {{ 'checked' }} @endif />
                        <label for="posalji_yes">{{ __('app.profile.yes') }}</label>
                    </div>
                </div>
            </div>
            <button class="add-new-contact-btn flex rounded-md text-xl justify-center mt-10 w-2/4 py-2 mx-auto"
                type="submit">{{ __('app.profile.change') }}</button>
        </form>
    </div>

    <div class="flex mt-3 flex-col">
        <p class="text-2xl font-bold mt-5" id="profile_change">{{ __('app.profile.update-profile') }} :</p>
        <form method="POST" action="{{ route('worker.personal.account.settings.change-data') }}"
            enctype='multipart/form-data'>
            @csrf
            @method('PUT')

            <!-- Phone -->
            <div class="flex flex-col">
                <label for="phone" class="sm:text-xl text-base mb-2 mt-5">
                    {{ __('app.auth.phone-number') }}:
                </label>
                <input class="input-style {{ $errors->has('phone') ? 'border-error mb-1' : 'mb-3' }}" name="phone"
                    type="text" placeholder="{{ __('app.auth.phone-number') }}"
                    value="{{ auth('worker')->user()->phone }}">
                <p class="{{ $errors->has('phone') ? 'flex text-red mt-1 pl-1' : 'hidden' }}">
                    {{ $errors->first('phone') }}</p>
            </div>

            <!-- CV -->
            <div class="flex flex-col">
                <label for="cv" class="sm:text-xl text-base mb-2 mt-5">
                    {{ __('app.auth.o-mojstoru') }}:
                </label>
                <textarea name="cv" placeholder="{{ __('app.auth.o-mojstoru') }}" rows="4"
                    class="input-style w-full {{ $errors->has('cv') ? 'border-error mb-1' : 'mb-3' }}">{{ auth('worker')->user()->cv }}</textarea>
                <p class="{{ $errors->has('cv') ? 'flex text-red mt-1 pl-1' : 'hidden' }}">
                    {{ $errors->first('cv') }}</p>
            </div>

            <!-- Profile Image -->
            <div class="mt-5">
                <label for="user_image" class="sm:text-xl text-base mb-2 mt-5">
                    {{ __('app.auth.profile-pics') }}:
                </label>

                @if (auth('worker')->user()->image != null)
                    <img src="{{ route('show.avatar', ['filename' => auth('worker')->user()->image]) }}"
                        class="mt-2 profile-image profile-img">
                @else
                    <img src="{{ asset('img/avatar_placeholder.svg') }}" class="mt-2 profile-image profile-img">
                @endif

                <div class="flex flex-col sm:flex-row mt-4">
                    <label for="file-upload" class="image-upload-btn px-4 py-3 cursor-pointer text-center">
                        {{ __('app.profile.choose-image') }}
                    </label>
                    <input id="file-upload" name="user_image" type="file" style="display:none;">
                    <input id="uploadFile" class="text-center sm:text-left sm:pl-3 pl-0 sm:mt-0 mt-2 max-w-full"
                        placeholder="{{ __('app.profile.no-img-selected') }}" disabled="disabled" />
                </div>
                <p class="{{ $errors->has('user_image') ? 'flex text-red mt-2 pl-1' : 'hidden' }}">
                    {{ $errors->first('user_image') }}</p>
            </div>

            <button class="add-new-contact-btn mb-20 flex rounded-md text-xl justify-center mt-10 w-2/4 py-2 mx-auto"
            type="submit">{{ __('app.profile.change') }}</button>
        </form>
    </div>

    <script>
        document.getElementById("file-upload").onchange = function() {
            document.getElementById("uploadFile").value = this.value.replace('C:\\fakepath\\', ' ');
        };

        const input = document.getElementById("file-upload");
        const preview = document.querySelector(".preview");
        const image = document.querySelector(".profile-img");
        input.addEventListener("change", updateImageDisplay);

        function updateImageDisplay() {
            const curFiles = input.files;
            image.src = URL.createObjectURL(curFiles[0]);
            image.style.opacity = 1;
        }
    </script>

    <style>
        [type="radio"]:checked,
        [type="radio"]:not(:checked) {
            display: none;
        }

        [type="radio"]:checked+label {
            position: relative;
            padding-left: 40px;
            cursor: pointer;
            line-height: 28px;
            display: inline-block;
            color: #000;
        }

        [type="radio"]:not(:checked)+label {
            position: relative;
            padding-left: 40px;
            cursor: pointer;
            line-height: 28px;
            display: inline-block;
            color: #666;
        }

        [type="radio"]:checked+label:before,
        [type="radio"]:not(:checked)+label:before {
            content: "";
            position: absolute;
            left: -1px;
            top: -1px;
            width: 30px;
            height: 30px;
            border: 1px solid #ddd;
            border-radius: 100%;
            background: #fff;
        }

        [type="radio"]:checked+label:after,
        [type="radio"]:not(:checked)+label:after {
            content: "";
            width: 20px;
            height: 20px;
            background: #0d2c5a;
            position: absolute;
            top: 4px;
            left: 4px;
            border-radius: 100%;
            -webkit-transition: all 0.2s ease;
            transition: all 0.2s ease;
        }

        [type="radio"]:not(:checked)+label:after {
            opacity: 0;
            -webkit-transform: scale(0);
            transform: scale(0);
        }

        [type="radio"]:checked+label:after {
            opacity: 1;
            -webkit-transform: scale(1);
            transform: scale(1);
        }
    </style>
</x-worker-profile-layout>
