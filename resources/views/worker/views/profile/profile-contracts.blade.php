<x-worker-profile-layout>
    <x-slot name="pageTitle">
        {{ __("app.profile.contracts") }}
    </x-slot>
    <x-slot name="header">
    </x-slot>
    <div class="flex profile-title">
        <p class="text-3xl font-bold">{{ __("app.profile.contracts") }} :</p>
    </div>
    <div class="flex mt-3 flex-col">
        <div class="mt-10 flex justify-center flex-col lg:flex-row w-1/3 items-center gap-4">
            <a href="{{ route('worker.archive.download.empty.contract') }}"
                class="archive-pdf-btn">
                <i class="ri-download-2-line"></i>{{ __("app.profile.download-empty-contract") }}
            </a>
        </div>
    </div>
</x-worker-profile-layout>
