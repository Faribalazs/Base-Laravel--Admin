<x-app-worker-layout>

    <x-slot name="pageTitle">
        {{ __('app.categories.new-pozicija-title') }}
    </x-slot>
    <x-slot name="header">
        {{ __('app.categories.new-pozicija-title') }}
    </x-slot>
    <x-slot name="import">
        <script src="{{ mix('js/vue.js') }}"></script>
    </x-slot>

    @if (count($errors) != 0)
        <script>
            Swal.fire({
                title: "{{ $errors->first() }}",
                icon: "error"
            });
        </script>
    @endif

    <form method="POST" id="add_new_category" onkeydown="return event.key != 'Enter';" class="mt-36" action="{{ route('worker.options.store.new.pozicija') }}">

        @csrf

        @php

            $subcategories_data = $custom_subcategories->merge($subcategories);
            $lang = app()->getLocale();

        @endphp

        <dropdown
            :data="{{ json_encode($subcategories_data) }}"
            :title="{{ json_encode( __('app.create-ponuda.choose-subcategory')) }}"
            :searchtext="{{ json_encode(__('app.create-ponuda.search')) }}"
            :locale="{{ json_encode($lang) }}"
            :inputname="{{ json_encode('subcategory') }}">
        </dropdown>

        <div class="flex flex-col">
            <span class="input-label pl-2 mb-3">{{ __('app.create-ponuda.swal-pozicija-name') }}*</span>
            <input type="text" name="pozicija_name_sr" value="{{ old('pozicija_name_sr') }}" class="input-style" id="inputTextName">

            <span class="input-label pl-2 mt-20 mb-3">{{ __('app.create-ponuda.swal-pozicija-des') }}*</span>
            <textarea name="poz_des_sr" rows="5" class="input-style mb-3" id="inputTextDes">{{ old('poz_des_sr') }}</textarea>
        </div>

        <dropdown
            :data="{{ json_encode($units) }}"
            :title="{{ json_encode( __('app.categories.choose-calculation')) }}"
            :searchtext="{{ json_encode(__('app.create-ponuda.search')) }}"
            :locale="{{ json_encode($lang) }}"
            :inputname="{{ json_encode('unit_id') }}">
        </dropdown>

        <div class="flex justify-center">
            <button type="submit" class="main-btn mx-auto mt-10">{{ __('app.basic.save') }}</button>
        </div>
    </form>

    <script>
        window.addEventListener('keydown', function(e) {
            if (e.keyIdentifier == 'U+000A' || e.keyIdentifier == 'Enter' || e.keyCode == 13) {
                if (e.target.nodeName == 'INPUT' && e.target.type == 'text') {
                    e.preventDefault();
                    return false;
                }
            }
        }, true);

    </script>

</x-app-worker-layout>
