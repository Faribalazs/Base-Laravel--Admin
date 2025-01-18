<x-app-worker-layout>
    <x-slot name="pageTitle">
        {{ __('app.profile.legal-entity') }}
    </x-slot>
    <x-slot name="header">
        {{ __('app.archive-selected.generate-pdf') }}
    </x-slot>
    <div class="mt-24 font-bold text-3xl">
        @if ($method == 'contact')
            <p class="text-center">
                {{ __('app.generate-pdf.choose-from-db') }}
            </p>
        @elseif ($method == 'add_new')
            <p class="text-center">
                {{ __('app.generate-pdf.fill-form') }}
            </p>
        @endif
    </div>
    <form method="POST" id="form1" action="{{ route('worker.archive.submit.contact.pravna') }}">
        @csrf
        <div class="flex mt-16 flex-col min-height justify-between">
            @if ($method == 'contact')
                <div id="contact-dropdown" class="flex w-full items-center justify-center relative">
                    <div class="select-menu w-full">
                        <div class="select-btn">
                            <span class="sBtn-text">{{ __('app.generate-pdf.choose-contact') }}</span>
                            <svg role="img" viewBox="0 0 512 512">
                                <path
                                    d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z" />
                            </svg>
                        </div>
                        <ul class="options absolute" id="ul">
                            <li class="option">
                                <input type="text" placeholder="{{ __('app.create-ponuda.search') }}..." id="search"
                                    onkeyup="filterFunctionCategory()" class="w-full dropdown-search">
                            </li>
                            @foreach ($pravna_lica as $client)
                                <li class="option">
                                    <span class="option-text">{{ $client->company_name }}</span>
                                    <p class="hidden client_id">{{ $client->id }}</p>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <script>
                    const optionMenu = document.querySelector(".select-menu"),
                        selectBtn = optionMenu.querySelector(".select-btn"),
                        options = optionMenu.querySelectorAll(".option"),
                        sBtn_text = optionMenu.querySelector(".sBtn-text");

                    selectBtn.addEventListener("click", () =>
                        optionMenu.classList.toggle("active")
                    );

                    options.forEach((option) => {
                        option.addEventListener("click", () => {
                            let selectedOption = option.querySelector(".option-text").innerText;
                            var selectedOptionId = option.querySelector(".client_id").innerText;
                            sBtn_text.innerText = selectedOption;
                            var existInput = document.getElementById("pravno_id");
                            if (!existInput) {
                                var div = document.getElementById("contact-dropdown");
                                var input = document.createElement("input");
                                var value = document.createTextNode(selectedOptionId);
                                input.id = "pravno_id";
                                input.name = "pravno_id";
                                input.type = "text";
                                input.defaultValue = selectedOptionId;
                                input.value = selectedOptionId;
                                input.appendChild(value);
                                div.appendChild(input);
                                categoryId = selectedOptionId;
                            } else {
                                existInput.remove();
                                var div = document.getElementById("contact-dropdown");
                                var input = document.createElement("input");
                                var value = document.createTextNode(selectedOptionId);
                                input.id = "pravno_id";
                                input.name = "pravno_id";
                                input.type = "text";
                                input.defaultValue = selectedOptionId;
                                input.value = selectedOptionId;
                                input.appendChild(value);
                                div.appendChild(input);
                                categoryId = selectedOptionId;
                            }
                            optionMenu.classList.remove("active");
                        });
                    });

                    function filterFunctionCategory() {
                        var input, filter, ul, li, a, i;
                        input = document.getElementById("search");
                        filter = input.value.toUpperCase();
                        div = document.getElementById("ul");
                        a = div.getElementsByTagName("span");
                        for (i = 0; i < a.length; i++) {
                            txtValue = a[i].textContent || a[i].innerText;
                            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                a[i].parentElement.style.display = "";
                            } else {
                                a[i].parentElement.style.display = "none";
                            }
                        }
                    }
                </script>
            @elseif($method == 'add_new')
                <div class="flex flex-col w-full">
                    <div class="flex flex-col w-full" id="pravna_lica">
                        <label for="company" class="sm:text-xl text-base my-3">{{ __('app.profile.company-name') }}* :</label>
                        <input class="input-style {{ $errors->has('company') ? 'border-error mb-1' : 'mb-3' }}"
                            name="company" value="{{ old('company') }}" maxlength="25" type="text" required />
                        <p class="{{ $errors->has('company') ? 'flex text-red mt-1 pl-1' : 'hidden' }}">
                            {{ $errors->first('company') }}</p>

                        <div class="flex lg:flex-row flex-col">
                            <div class="flex w-full lg:w-1/2 flex-col lg:pr-2 pr-0">
                                <label for="email" class="sm:text-xl text-base my-3">{{ __('app.profile.email') }}* :</label>
                                <input class="input-style {{ $errors->has('email') ? 'border-error mb-1' : 'mb-3' }}"
                                    name="email" value="{{ old('email') }}" maxlength="20" type="text" required />
                                <p class="{{ $errors->has('email') ? 'flex text-red mt-1 pl-1' : 'hidden' }}">
                                    {{ $errors->first('email') }}</p>
                            </div>
                            <div class="flex w-full lg:w-1/2 flex-col lg:pl-2 pl-0">
                                <label for="tel" class="sm:text-xl text-base my-3">{{ __('app.profile.telefon') }}* :</label>
                                <input class="input-style {{ $errors->has('tel') ? 'border-error mb-1' : 'mb-3' }}"
                                    name="tel" value="{{ old('tel') }}" maxlength="25" type="text"
                                    required />
                                <p class="{{ $errors->has('tel') ? 'flex text-red mt-1 pl-1' : 'hidden' }}">
                                    {{ $errors->first('tel') }}</p>
                            </div>
                        </div>

                        <label for="pib" class="sm:text-xl text-base my-3">{{ __('app.profile.pib') }}* :</label>
                        <input class="input-style {{ $errors->has('pib') ? 'border-error mb-1' : 'mb-3' }}"
                            name="pib" value="{{ old('pib') }}" maxlength="25" type="text" required />
                        <p class="{{ $errors->has('pib') ? 'flex text-red mt-1 pl-1' : 'hidden' }}">
                            {{ $errors->first('pib') }}</p>

                        <div class="flex lg:flex-row flex-col">
                            <div class="flex w-full lg:w-1/2 flex-col lg:pr-2 pr-0">
                                <label for="grad" class="sm:text-xl text-base my-3">{{ __('app.profile.city') }}* :</label>
                                <input class="input-style {{ $errors->has('grad') ? 'border-error mb-1' : 'mb-3' }}"
                                    name="grad" value="{{ old('grad') }}" maxlength="20" type="text"
                                    required />
                                <p class="{{ $errors->has('grad') ? 'flex text-red mt-1 pl-1' : 'hidden' }}">
                                    {{ $errors->first('grad') }}</p>
                            </div>
                            <div class="flex w-full lg:w-1/2 flex-col lg:pl-2 pl-0">
                                <label for="postcode" class="sm:text-xl text-base my-3">{{ __('app.profile.post-code') }}* :</label>
                                <input
                                    class="input-style {{ $errors->has('postcode') ? 'border-error mb-1' : 'mb-3' }}"
                                    name="postcode" value="{{ old('postcode') }}" maxlength="25" type="text"
                                    required />
                                <p class="{{ $errors->has('postcode') ? 'flex text-red mt-1 pl-1' : 'hidden' }}">
                                    {{ $errors->first('postcode') }}</p>
                            </div>
                        </div>

                        <label for="adresa" class="sm:text-xl text-base my-3">{{ __('app.profile.address') }}* :</label>
                        <input class="input-style {{ $errors->has('adresa') ? 'border-error mb-1' : 'mb-3' }}"
                            name="adresa" value="{{ old('adresa') }}" maxlength="25" type="text" required />
                        <p class="{{ $errors->has('adresa') ? 'flex text-red mt-1 pl-1' : 'hidden' }}">
                            {{ $errors->first('adresa') }}</p>

                    </div>
                </div>
                <div class="flex items-center mt-5">
                    <label for="save" class="text-xl my-3">{{ __('app.profile.save-contact') }}</label>
                    <input type="checkbox" class="ml-3" name="save" value="1" />
                </div>
        </div>
        @endif
        
        <input type="hidden" value="{{ $id }}" name="ponuda_id">
        <input type="hidden" value="{{ $lice }}" name="lice">
        <input type="hidden" value="{{ $method }}" name="method">

        <div class="flex mt-20 sm:w-1/2 w-full mx-auto">
            <button type="submit" class="finish-btn mt-5 text-xl w-full">{{ __('app.generate-pdf.continue') }}</button>
        </div>
    </form>
    <style>
        #pravno_id {
            display: none;
        }

        .min-height {
            min-height: 40vh;
        }
    </style>
</x-app-worker-layout>
