<x-worker-profile-layout>
    <x-slot name="pageTitle">
        {{ __("app.profile.contact") }}
    </x-slot>
    <x-slot name="header">
    </x-slot>
    <div class="flex flex-col mb-20">
        @if ($lice == 'individual')
            <div class="flex mb-10 justify-between items-center">
                <p class="text-2xl">{{ __("app.profile.data-about") }} <b>{{ $contact->first_name }} {{ $contact->last_name }}</b></p>
                <a class="edit-btn-table sm:ml-0 ml-3" style="max-height: 44px"
                    href="{{ route('worker.personal.contacts.edit.fizicka', ['id' => $contact->id]) }}">
                    <i class="ri-edit-line"></i>
                </a>
            </div>
            <p class="text-xl pb-2"><b>{{ __("app.profile.name-and-surname") }} :</b> {{ $contact->first_name }} {{ $contact->last_name }}</p>
            <p class="text-xl pb-2"><b>{{ __("app.profile.email") }} :</b> {{ $contact->email }}</p>
            <p class="text-xl pb-2"><b>{{ __("app.profile.telefon") }} :</b> {{ $contact->phone }}</p>
            <p class="text-xl pb-2"><b>{{ __("app.profile.city") }} :</b> {{ $contact->city }}</p>
            <p class="text-xl pb-2"><b>{{ __("app.profile.post-code") }} :</b> {{ $contact->zip_code }}</p>
            <p class="text-xl"><b>{{ __("app.profile.address") }} :</b> {{ $contact->address }}</p>
        @elseif ($lice == 'legal-entity')
            <div class="flex mb-10 justify-between items-center">
                <p class="text-2xl">{{ __("app.profile.data-about") }} <b>{{ $contact->company_name }}</b></p>
                <a class="edit-btn-table sm:ml-0 ml-3" style="max-height: 44px"
                    href="{{ route('worker.personal.contacts.edit.pravna', ['id' => $contact->id]) }}">
                    <i class="ri-edit-line"></i>
                </a>
            </div>
            <p class="text-xl pb-2"><b>{{ __("app.profile.company-name") }} :</b> {{ $contact->company_name }}</p>
            <p class="text-xl pb-2"><b>{{ __("app.profile.pib") }} :</b> {{ $contact->pib }}</p>
            <p class="text-xl pb-2"><b>{{ __("app.profile.email") }} :</b> {{ $contact->email }}</p>
            <p class="text-xl pb-2"><b>{{ __("app.profile.telefon") }} :</b> {{ $contact->phone }}</p>
            <p class="text-xl pb-2"><b>{{ __("app.profile.city") }} :</b> {{ $contact->city }}</p>
            <p class="text-xl pb-2"><b>{{ __("app.profile.post-code") }} :</b> {{ $contact->zip_code }}</p>
            <p class="text-xl"><b>{{ __("app.profile.address") }} :</b> {{ $contact->address }}</p>
        @endif
    </div>
</x-worker-profile-layout>
