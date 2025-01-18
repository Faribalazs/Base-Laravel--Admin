<x-app-worker-layout>
    <x-slot name="pageTitle">
        {{ __('app.generate-pdf.choose-contact') }}
    </x-slot>
    <x-slot name="header">
        {{ __('app.archive-selected.generate-pdf') }}
    </x-slot>
    <div class="mt-32 font-bold text-3xl">
        <p class="text-center">
            {{ __('app.generate-pdf.contact-from-db-or-add-new') }}?
        </p>
    </div>
    <div class="mt-24 flex flex-col items-center gap-10">
        <div class="sm:w-1/2 w-full">
            @if ((isset($fizicka_lica) && count($fizicka_lica)) || (isset($pravna_lica) && count($pravna_lica)))
                <a href="{{ route('worker.archive.show.lica', ['lice' => $lice, 'method' => 'contact', 'id' => $id]) }}">
                    <button class="confirm-btn">{{ __('app.generate-pdf.choose-from-db') }}</button>
                </a>
            @else
                <button class="disabled-btn" disabled >{{ __('app.generate-pdf.choose-contact') }}</button>
                <p class="text-red mt-2 text-center">{{ __('app.generate-pdf.no-added-contact') }}</p>
            @endif
        </div>
        <div class="sm:w-1/2 w-full justify-center">
            <a href="{{ route('worker.archive.show.lica', ['lice' => $lice, 'method' => 'add_new', 'id' => $id]) }}">
                <button class="confirm-btn">{{ __('app.generate-pdf.add-new-contact') }}</button>
            </a>
        </div>
    </div>
</x-app-worker-layout>
