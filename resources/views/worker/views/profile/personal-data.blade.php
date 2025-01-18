<x-worker-profile-layout>
    <x-slot name="pageTitle">
        {{ __('app.profile.company-data') }}
    </x-slot>
    <x-slot name="header">
    </x-slot>
    <div class="flex profile-title">
        <p class="{{ Auth::guard('worker')->user()->hasRole('super_worker')? '': 'mb-4' }} text-3xl font-bold">
            {{ __('app.profile.company-data') }}</p>
    </div>
    @if (Auth::guard('worker')->user()->hasRole('super_worker') && !empty($company_data))
        <div class="mt-3">
            <form method="POST" action="{{ route('worker.personal.company.delete') }}">

                @csrf

                @method('DELETE')

                <button type="submit" class="finish-btn">
                    {{ __('app.basic.delete') }}
                </button>
            </form>
        </div>
    @endif
    @if (count($errors) > 0)
        <script>
            Swal.fire({
                icon: 'error',
                title: '{{ __('app.profile.something-wrong') }}'
            })
        </script>
    @endif
    @if (!empty($company_data))
        <div class="flex mt-3 flex-col">
            <div class="flex gap-1 flex-wrap mb-3">
                <p class="sm:text-xl text-base font-bold">{{ __('app.profile.company-name') }} :</p>
                <p class="sm:text-xl text-base">{{ $company_data->company_name }}</p>
            </div>
            <div class="flex gap-1 flex-wrap mb-3">
                <p class="sm:text-xl text-base font-bold">{{ __('app.profile.country') }} :</p>
                <p class="sm:text-xl text-base">{{ $company_data->country }}</p>
            </div>
            <div class="flex gap-1 flex-wrap mb-3">
                <p class="sm:text-xl text-base font-bold">{{ __('app.profile.city') }} :</p>
                <p class="sm:text-xl text-base">{{ $company_data->city }}</p>
            </div>
            <div class="flex gap-1 flex-wrap mb-3">
                <p class="sm:text-xl text-base font-bold">{{ __('app.profile.post-code') }} :</p>
                <p class="sm:text-xl text-base">{{ $company_data->zip_code }}</p>
            </div>
            <div class="flex gap-1 flex-wrap mb-3">
                <p class="sm:text-xl text-base font-bold">{{ __('app.profile.address') }} :</p>
                <p class="sm:text-xl text-base">{{ $company_data->address }}</p>
            </div>
            <div class="flex gap-1 flex-wrap mb-3">
                <p class="sm:text-xl text-base font-bold">{{ __('app.profile.telefon') }} :</p>
                <p class="sm:text-xl text-base">{{ $company_data->phone }}</p>
            </div>
            <div class="flex gap-1 flex-wrap mb-3">
                <p class="sm:text-xl text-base font-bold">{{ __('app.profile.pib') }} :</p>
                <p class="sm:text-xl text-base">{{ $company_data->pib }}</p>
            </div>
            <div class="flex gap-1 flex-wrap mb-3">
                <p class="sm:text-xl text-base font-bold">{{ __('app.profile.id-number') }} :</p>
                <p class="sm:text-xl text-base">{{ $company_data->maticni_broj }}</p>
            </div>
            <div class="flex gap-1 flex-wrap mb-3">
                <p class="sm:text-xl text-base font-bold">{{ __('app.profile.bank-account') }} :</p>
                <p class="sm:text-xl text-base">{{ $company_data->tekuci_racun }}</p>
            </div>
            <div class="flex gap-1 flex-wrap mb-3">
                <p class="sm:text-xl text-base font-bold">{{ __('app.profile.bank-name') }} :</p>
                <p class="sm:text-xl text-base">{{ $company_data->bank_name }}</p>
            </div>
            <div class="flex gap-1 flex-col mb-3">
                <p class="sm:text-xl text-base font-bold mb-1">{{ __('app.profile.company-logo') }} :</p>
                <img src="{{ url('storage/' . $company_data->logo) }}" alt="{{ $company_data->company_name }}"
                    style="width:500px; height: 240px; object-fit: cover;">
            </div>
        </div>
    @else
        <div class="flex mt-3 flex-col">
            <form method="POST" action="{{ route('worker.personal.data.save') }}" class="flex flex-col"
                enctype="multipart/form-data">

                @csrf

                <!-- Company Name -->
                <label for="company_name"
                    class="sm:text-xl text-base my-3">{{ __('app.profile.company-name-correct') }}* :</label>
                <input class="input-style {{ $errors->has('company_name') ? 'border-error mb-1' : 'mb-3' }}"
                    placeholder="{{ __('app.profile.company-name-correct') }}" name="company_name" value="{{ old('company_name') }}" maxlength="50" type="text" required />

                <!-- Country -->
                <label for="country" class="sm:text-xl text-base mb-3 lg:mt-7 mt-5">{{ __('app.profile.country') }}* :</label>
                <input placeholder="{{ __('app.profile.country') }}" class="input-style {{ $errors->has('country') ? 'border-error mb-1' : 'mb-3' }}" name="country" value="{{ old('country') }}"
                    maxlength="20" type="text" required />

                <div class="flex lg:flex-row flex-col">
                    <div class="flex w-full lg:w-1/2 flex-col lg:pr-2 pr-0">

                        <!-- City -->
                        <label for="city" class="sm:text-xl text-base mb-3 lg:mt-7 mt-5">{{ __('app.profile.city') }}* :</label>
                        <input placeholder="{{ __('app.profile.city') }}" class="input-style {{ $errors->has('city') ? 'border-error mb-1' : 'mb-3' }}"
                            name="city" value="{{ old('city') }}" maxlength="30" type="text" required />

                    </div>
                    <div class="flex w-full lg:w-1/2 flex-col lg:pl-2 pl-0">

                        <!-- Postcode -->
                        <label for="postcode" class="sm:text-xl text-base mb-3 lg:mt-7 mt-5">{{ __('app.profile.post-code') }}*
                            :</label>
                        <input placeholder="{{ __('app.profile.post-code') }}" class="input-style {{ $errors->has('postcode') ? 'border-error mb-1' : 'mb-3' }}"
                            name="postcode" value="{{ old('postcode') }}" maxlength="10" type="text" required />
                        <p class="{{ $errors->has('postcode') ? 'flex text-red mt-1 pl-1' : 'hidden' }}">
                            {{ $errors->first('postcode') }}</p>
                    </div>
                </div>

                <!-- Address -->
                <label for="address" class="sm:text-xl text-base mb-3 lg:mt-7 mt-5">{{ __('app.profile.address') }}* :</label>
                <input placeholder="{{ __('app.profile.address') }}" class="input-style {{ $errors->has('address') ? 'border-error mb-1' : 'mb-3' }}"
                    name="address" value="{{ old('address') }}" maxlength="50" type="text" required />

                <!-- E mail -->
                <label for="email" class="sm:text-xl text-base mb-3 lg:mt-7 mt-5">{{ __('app.profile.email') }}* :</label>
                <input placeholder="{{ __('app.profile.email') }}" class="input-style {{ $errors->has('email') ? 'border-error mb-1' : 'mb-3' }}" name="email"
                    value="{{ old('email') }}" maxlength="40" type="text" required />
                <p class="{{ $errors->has('email') ? 'flex text-red mt-1 pl-1' : 'hidden' }}">
                    {{ $errors->first('email') }}</p>

                <!-- Phone -->
                <label for="phone" class="sm:text-xl text-base mb-3 lg:mt-7 mt-5">{{ __('app.profile.telefon') }}* :</label>
                <input placeholder="{{ __('app.profile.telefon') }}" class="input-style {{ $errors->has('phone') ? 'border-error mb-1' : 'mb-3' }}" name="phone"
                    value="{{ old('phone') }}" maxlength="25" type="text" required />
                <p class="{{ $errors->has('phone') ? 'flex text-red mt-1 pl-1' : 'hidden' }}">
                    {{ $errors->first('phone') }}</p>

                <div class="flex lg:flex-row flex-col">
                    <div class="flex w-full lg:w-1/2 flex-col lg:pr-2 pr-0">

                        <!-- PIB -->
                        <label for="pib" class="sm:text-xl text-base mb-3 lg:mt-7 mt-5">{{ __('app.profile.pib') }}*
                            :</label>
                        <input placeholder="{{ __('app.profile.pib') }}" class="input-style {{ $errors->has('pib') ? 'border-error mb-1' : 'mb-3' }}"
                            name="pib" value="{{ old('pib') }}" maxlength="20" type="text" required />
                        <p class="{{ $errors->has('pib') ? 'flex text-red mt-1 pl-1' : 'hidden' }}">
                            {{ $errors->first('pib') }}</p>
                    </div>
                    <div class="flex w-full lg:w-1/2 flex-col lg:pl-2 pl-0">

                        <!-- JMBG -->
                        <label for="maticni_broj"
                            class="sm:text-xl text-base mb-3 lg:mt-7 mt-5">{{ __('app.profile.id-number') }}* :</label>
                        <input placeholder="{{ __('app.profile.id-number') }}" class="input-style {{ $errors->has('maticni_broj') ? 'border-error mb-1' : 'mb-3' }}"
                            name="maticni_broj" value="{{ old('maticni_broj') }}" maxlength="25" type="text"
                            required />
                        <p class="{{ $errors->has('maticni_broj') ? 'flex text-red mt-1 pl-1' : 'hidden' }}">
                            {{ $errors->first('maticni_broj') }}</p>
                    </div>
                </div>

                <!-- Racun -->
                <label for="tekuci_racun" class="sm:text-xl text-base mb-3 lg:mt-7 mt-5">{{ __('app.profile.bank-account') }}*
                    :</label>
                <input placeholder="{{ __('app.profile.bank-account') }}" class="input-style {{ $errors->has('tekuci_racun') ? 'border-error mb-1' : 'mb-3' }}"
                    name="tekuci_racun" value="{{ old('tekuci_racun') }}" maxlength="30" type="text" required />
                <p class="{{ $errors->has('tekuci_racun') ? 'flex text-red mt-1 pl-1' : 'hidden' }}">
                    {{ $errors->first('tekuci_racun') }}</p>

                <!-- Bank Name -->
                <label for="bank_name" class="sm:text-xl text-base mb-3 lg:mt-7 mt-5">{{ __('app.profile.bank-name') }}* :</label>
                <input placeholder="{{ __('app.profile.bank-name') }}" class="input-style {{ $errors->has('bank_name') ? 'border-error mb-1' : 'mb-3' }}"
                    name="bank_name" value="{{ old('bank_name') }}" maxlength="30" type="text" required />
                <p class="{{ $errors->has('bank_name') ? 'flex text-red mt-1 pl-1' : 'hidden' }}">
                    {{ $errors->first('bank_name') }}</p>

                <!-- Company Logo -->
                <label class="sm:text-xl text-base mb-3 lg:mt-7 mt-5">
                    {{ __('app.profile.company-logo') }}* :
                </label>
                <div class="flex flex-col sm:flex-row">
                    <label for="file-upload" class="image-upload-btn sm:text-xl text-base px-4 py-3 cursor-pointer text-center">
                        {{ __('app.profile.choose-image') }}
                    </label>
                    <input id="file-upload" name="logo" type="file" style="display:none;">
                    <input id="uploadFile" class="text-center sm:text-left sm:pl-3 pl-0 sm:text-xl text-base sm:mt-0 mt-2 max-w-full"
                        placeholder="{{ __('app.profile.no-img-selected') }}" disabled="disabled" />
                </div>
                <p class="{{ $errors->has('logo') ? 'flex text-red mt-2 pl-1' : 'hidden' }}">
                    {{ $errors->first('logo') }}</p>

                <!-- Submit Button -->
                <button type="submit"
                    class="finish-btn sm:mt-20 mt-12 mb-20 sm:text-xl text-base">{{ __('app.profile.save-data') }}</button>
            </form>
        </div>

        <script>
            document.getElementById("file-upload").onchange = function() {
                document.getElementById("uploadFile").value = this.value.replace('C:\\fakepath\\', ' ');
            };
        </script>
    @endif
</x-worker-profile-layout>
