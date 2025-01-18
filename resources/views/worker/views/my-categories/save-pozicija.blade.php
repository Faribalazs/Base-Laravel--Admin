<x-app-worker-layout>

    <x-slot name="pageTitle">
        {{ __('app.categories.update-position') }}
    </x-slot>
    <x-slot name="header">
        {{ __('app.categories.update-position') }}
    </x-slot>
    <x-slot name="import">
        <script src="{{ mix('js/vue.js') }}"></script>
    </x-slot>

    @php
        $pozicija_title = $pozicija->title ?? null;
        $pozicija_desc = $pozicija->description === "&nbsp;" ? '' : $pozicija->description;
        $pozicija_unit = $pozicija->unit->name ?? null;
        $pozicija_id = $pozicija->id ?? null;
    @endphp

    @if (count($errors) != 0)
        <script>
            Swal.fire({
                title: "{{ $errors->first() }}",
                icon: "error"
            });
        </script>
    @endif

    <div class="md:flex hidden w-full justify-end mt-5">
        <button type="button" class="delete-btn-table text-white flex gap-2 py-3 md:text-xl text-lg px-8"
            onclick="actionSwall('{{ route('worker.options.delete.pozicija') }}','{{ $pozicija_id }}')">
            {{ __('app.categories.delete-pozicija') }}
            <i class="ri-delete-bin-line"></i>
        </button>
    </div>

    <div class="mt-3">
        <div class="flex w-full">
            <form method="POST" id="formPozicija" onkeydown="return event.key != 'Enter';" action="{{ route('worker.options.update.pozicija') }}"
                class="mt-10 flex flex-col w-full">

                @csrf
                @method('PUT')

                @php

                    $lang = app()->getLocale();
        
                @endphp

                <span class="input-label md:text-xl text-lg py-3">{{ __('app.categories.write-name-position') }}*</span>
                <input type="text" placeholder="{{ $pozicija_title }}" value="{{ $pozicija_title }}" name="title"
                    class="w-full input-style md:text-xl text-lg">

                <span
                    class="input-label py-3 md:text-xl text-lg mt-5">{{ __('app.categories.description-position') }}*</span>
                <textarea type="text" rows="5" value="{{ $pozicija_desc }}" name="description"
                    class="w-full input-style md:text-xl text-lg">{{ $pozicija_desc }}</textarea>
                    

                <input type="hidden" name="id" value="{{ $pozicija_id }}" class="w-full dropdown-search mt-4">

                
                <dropdown
                    :data="{{ json_encode($units) }}"
                    :title="{{ json_encode( __('app.categories.choose-calculation')) }}"
                    :searchtext="{{ json_encode(__('app.create-ponuda.search')) }}"
                    :locale="{{ json_encode($lang) }}"
                    :inputname="{{ json_encode('unit') }}"
                    :preselectedname="{{ json_encode($pozicija_unit) }}"
                    :preselectedid="{{ json_encode($pozicija->unit_id) }}">
                </dropdown>

                <button type="submit"
                    class="main-btn mx-auto md:w-1/2 w-full md:text-xl text-lg md:mt-20 mt-12">{{ __('app.basic.save') }}</button>

                <button type="button"
                    class="delete-btn-table text-white flex gap-2 md:text-xl mt-10 py-3 md:hidden text-lg px-8"
                    onclick="actionSwall('{{ route('worker.options.delete.category') }}','{{ $pozicija_id }}')">
                    {{ __('app.categories.delete-category') }}
                    <i class="ri-delete-bin-line"></i>
                </button>
            </form>
        </div>
    </div>

    <script>
        function actionSwall(url, id) {
            Swal.fire({
                title: '{{ __('app.create-ponuda.swal-are-you-sure-delete') }}?',
                icon: 'question',
                confirmButtonText: "{{ __('app.basic.delete') }}",
                cancelButtonText: "Nazad",
                showConfirmButton: false,
                showCancelButton: false,
                showCloseButton: true,
                confirmButtonColor: '#22ff00',
                cancelButtonColor: '#d33',
                html: '<form method="POST" id="delete" action="' + url + '">' +
                    '@csrf' +
                    '@method('put')' +
                    '<input name="id" hidden value="' + id + '">' +
                    '<button type="submit" class="add-new-btn py-4 px-10 mx-1 mt-5">{{ __('app.basic.delete') }}</button>' +
                    '</form>',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location = url;
                }
            })
        }
    </script>

</x-app-worker-layout>
