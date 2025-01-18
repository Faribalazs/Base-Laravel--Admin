<x-app-worker-layout>
    <x-slot name="pageTitle">
        {{ __('app.generate-pdf.sending-email') }}
    </x-slot>
    <x-slot name="header">
        {{ __('app.generate-pdf.send-ponuda') }}
    </x-slot>
    <div class="my-12 font-bold text-3xl">
        <p class="text-center">
            {{ __('app.generate-pdf.send-ponuda-name') }} :
            <b>{{ isset($id) ? "{$name}." . __('app.generate-pdf.pdf') : $name . ' ' . ($ugovor_br ?? '') }}</b>
        </p>
    </div>
    @php
        $route = isset($fields) ? 'worker.archive.send.contract' : 'worker.archive.send.mail';
    @endphp

    <form method="POST" id="sendPDF" action="{{ route($route) }}">
        @csrf
        @method('post')
        @if (isset($id))
            <input type="hidden" name="id" value="{{ $id }}" />
        @endif
        @if (isset($client_id))
            <input type="hidden" name="client_id" value="{{ $client_id }}" />
        @endif
        @if (isset($type))
            <input type="hidden" name="type" value="{{ $type }}" />
        @endif
        @if (isset($temporary))
            <input type="hidden" name="temporary" value="{{ $temporary }}" />
        @endif
        @if (isset($pdf_blade))
            <input type="hidden" name="pdf" value="{{ $pdf_blade }}" />
        @endif
        @if (isset($fields))
            <input type="hidden" name="fields"
                value="{{ htmlspecialchars(json_encode($fields), ENT_QUOTES, 'UTF-8') }}" />
        @endif
        @if (isset($ugovor_br))
            <input type="hidden" name="ugovor_br" value="{{ $ugovor_br }}" />
        @endif
        @if (isset($mailTo))
            <input type="hidden" name="mailTo" value="{{ $mailTo }}" />
        @endif

        <div class="flex flex-col">
            <label
                class="md:text-xl text-lg mt-0 mb-1 pl-2 md:mt-3">{{ __('app.generate-pdf.subject-email') }}:</label>
            <input type="text" placeholder="{{ __('app.generate-pdf.subject-email') }}" name="mailSubject"
                class="input-style
            {{ $errors->has('mailSubject') ? 'border-error mb-1' : 'mb-3' }}">
        </div>

        <div class="flex flex-col">
            <label class="md:text-xl text-lg mt-0 mb-1 pl-2 md:mt-3">{{ __('app.generate-pdf.body-email') }}:</label>
            <textarea placeholder="{{ __('app.generate-pdf.body-email') }}" name="mailBody"
                class="input-style
                {{ $errors->has('mailBody') ? 'border-error mb-1' : 'mb-3' }}" rows="4"
                cols="50"></textarea>
        </div>

        <div class="flex justify-center">
            <button type="submit"
            class="finish-btn mt-12 md:text-xl sm:w-auto w-full text-lg mb-12">{{ __('app.generate-pdf.send-ponuda') }}</button>
        </div>
    </form>
</x-app-worker-layout>
