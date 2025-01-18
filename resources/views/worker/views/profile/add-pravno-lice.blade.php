<x-worker-profile-layout>
    <x-slot name="pageTitle">
        {{ __('app.profile.add-legal-entity') }}
    </x-slot>

    <x-slot name="header">
    </x-slot>

    @if (count($errors) > 0)
        <script>
            Swal.fire({
                icon: 'error',
                title: '{{ __('app.profile.something-wrong') }}'
            })
        </script>
    @endif

    @if (isset($contact))
        <div class="flex w-full">
            <div class="flex md:w-1/2 w-full profile-title justify-start">
                <p class="text-3xl font-bold">{{ __('app.profile.modify-data') }}</p>
            </div>
            <div class="w-1/2 justify-end hidden md:flex">
                <form method="post" action="{{route('worker.personal.contacts.delete.fizicka')}}" class="flex w-100 flex-col">
                    @csrf
                    <input type="hidden" name="id" value="{{$contact->id}}"/>
                    <button type="submit" class="finish-btn w-full px-10 bg-red md:text-xl text-lg text-center">
                        {{ __('app.profile.delete-contact') }}<i class="ri-delete-bin-line pl-2"></i>
                    </button>
                </form>
            </div>
        </div>
    @else
        <div class="flex profile-title">
            <p class="text-3xl font-bold">{{ __('app.profile.add-legal-entity') }}</p>
        </div>
    @endif

    <div class="flex mt-3 flex-col">
        <form method="POST" action="{{ route('worker.personal.contacts.add.legal-entity.save') }}" class="flex flex-col">
            @csrf

            @if (isset($contact))
                <input type="hidden" name="id" value="{{ $contact->id }}" />
            @endif

            <div class="flex lg:flex-row flex-col lg:mt-4">
                <div class="flex w-full lg:w-1/2 flex-col lg:pr-2 pr-0">

                    <!-- Company Name -->
                    <label for="company_name"
                        class="md:text-xl text-lg mt-3 lg:mt-0 mb-1 pl-2">{{ __('app.profile.company-name') }}*</label>
                    <input
                        class="input-style
                {{ $errors->has('company_name') ? 'border-error mb-1' : 'mb-3' }}"
                        name="company_name"
                        value="{{ isset($contact->company_name) ? $contact->company_name : old('company_name') }}"
                        type="text" maxlength="30" placeholder="{{ __('app.profile.company-name') }}" required />


                </div>
                <div class="flex w-full lg:w-1/2 flex-col lg:pl-2 pl-0">

                    <!-- PIB -->
                    <label for="pib"
                        class="md:text-xl text-lg mt-0 mb-1 pl-2 md:mt-3">{{ __('app.profile.pib') }}*</label>
                    <input
                        class="input-style
                        {{ $errors->has('pib') ? 'border-error mb-1' : 'mb-3' }}"
                        name="pib" value="{{ isset($contact->pib) ? $contact->pib : old('pib') }}" type="text"
                        maxlength="50" placeholder="{{ __('app.profile.pib') }}" required />
                    <p class="{{ $errors->has('pib') ? 'flex text-red mt-1 pl-1' : 'hidden' }}">
                        {{ $errors->first('pib') }}
                    </p>

                </div>
            </div>

            <!-- City -->
            <label for="city"
                class="md:text-xl text-lg mt-0 mb-1 pl-2 md:mt-3">{{ __('app.profile.city') }}*</label>
            <input class="input-style
                {{ $errors->has('city') ? 'border-error mb-1' : 'mb-3' }}"
                name="city" value="{{ isset($contact->city) ? $contact->city : old('city') }}" type="text"
                maxlength="30" placeholder="{{ __('app.profile.city') }}" required />

            <div class="flex lg:flex-row flex-col">
                <div class="flex w-full lg:w-1/2 flex-col lg:pr-2 pl-0">

                    <!-- Address -->
                    <label for="address"
                        class="md:text-xl text-lg mt-0 mb-1 pl-2 md:mt-3">{{ __('app.profile.address') }}*</label>
                    <input
                        class="input-style
                        {{ $errors->has('address') ? 'border-error mb-1' : 'mb-3' }}"
                        name="address" value="{{ isset($contact->address) ? $contact->address : old('address') }}"
                        type="text" maxlength="50" placeholder="{{ __('app.profile.address') }}" required />

                </div>
                <div class="flex w-full lg:w-1/2 flex-col lg:pl-2 pl-0">

                    <!-- Postcode -->
                    <label for="postcode"
                        class="md:text-xl text-lg mt-0 mb-1 pl-2 md:mt-3">{{ __('app.profile.post-code') }}*</label>
                    <input
                        class="input-style
                        {{ $errors->has('postcode') ? 'border-error mb-1' : 'mb-3' }}"
                        name="postcode" value="{{ isset($contact->zip_code) ? $contact->zip_code : old('postcode') }}"
                        type="text" placeholder="{{ __('app.profile.post-code') }}" maxlength="10" required />
                    <p class="{{ $errors->has('postcode') ? 'flex text-red mt-1 pl-1' : 'hidden' }}">
                        {{ $errors->first('postcode') }}</p>
                </div>
            </div>

            <!-- Email -->
            <label for="email"
                class="md:text-xl text-lg mt-0 mb-1 pl-2 md:mt-3">{{ __('app.profile.email') }}*</label>
            <input class="input-style
                {{ $errors->has('email') ? 'border-error mb-1' : 'mb-3' }}"
                name="email" value="{{ isset($contact->email) ? $contact->email : old('email') }}" type="text"
                placeholder="{{ __('app.profile.email') }}" maxlength="50" required />
            <p class="{{ $errors->has('email') ? 'flex text-red mt-1 pl-1' : 'hidden' }}">
                {{ $errors->first('email') }}</p>

            <!-- Phone -->
            <label for="phone"
                class="md:text-xl text-lg mt-0 mb-1 pl-2 md:mt-3">{{ __('app.profile.telefon') }}*</label>
            <input class="input-style
                {{ $errors->has('phone') ? 'border-error mb-1' : 'mb-3' }}"
                name="phone" value="{{ isset($contact->phone) ? $contact->phone : old('phone') }}" type="text"
                placeholder="{{ __('app.profile.telefon') }}" maxlength="25" required />
            <p class="{{ $errors->has('phone') ? 'flex text-red mt-1 pl-1' : 'hidden' }}">
                {{ $errors->first('phone') }}</p>

            <!-- Submit Button -->
            @if (isset($contact))
                <button type="submit"
                    class="finish-btn mt-12 md:text-xl text-lg mb-12">{{ __('app.profile.modify-data') }}</button>
            @else
                <button type="submit"
                    class="finish-btn mt-12 md:text-xl text-lg mb-12">{{ __('app.profile.save-contact') }}</button>
            @endif

        </form>

        @if (isset($contact))
            <form method="post" action="{{ route('worker.personal.contacts.delete.pravna') }}" class="flex flex-col mb-20 md:hidden">

                @csrf

                <input type="hidden" name="id" value="{{ $contact->id }}" />
                <button type="submit" class="finish-btn bg-red md:text-xl text-lg text-center">
                    {{ __('app.profile.delete-contact') }}<i class="ri-delete-bin-line pl-2"></i>
                </button>
            </form>
        @endif

    </div>

</x-worker-profile-layout>
