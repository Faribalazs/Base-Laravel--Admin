<x-app-worker-layout>
    <x-slot name="pageTitle">
        {{ __('app.generate-pdf.choose-contact') }}
    </x-slot>
    <x-slot name="header">
        {{ __('app.archive-selected.generate-pdf') }}
    </x-slot>
    <div class="mt-32 font-bold text-3xl">
        <p class="text-center">
            {{ __('app.generate-pdf.to-whom-you-send') }}?
        </p>
    </div>
    <div class="mt-24 flex flex-col items-center gap-10">
        <div class="sm:w-1/2 w-full">
            <a href="{{ route('worker.archive.select.method', ['lice' => 'individual','id' => $id]) }}"><button class="confirm-btn">{{ __('app.generate-pdf.individual') }}</button></a>
        </div>
        <div class="sm:w-1/2 w-full justify-center">
            <a href="{{ route('worker.archive.select.method', ['lice' => 'legal-entity','id' => $id]) }}"><button class="confirm-btn">{{ __('app.generate-pdf.legal-entity') }}</button></a>
        </div>
    </div>
</x-app-worker-layout>
