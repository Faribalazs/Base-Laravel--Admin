<x-app-worker-layout>

    <x-slot name="pageTitle">
        {{ __('app.categories.new-subcategory-title') }}
    </x-slot>
    <x-slot name="header">
        {{ __('app.categories.new-subcategory-title') }}
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

    <form method="POST" id="add_new_category" onkeydown="return event.key != 'Enter';" class="mt-20" action="{{ route('worker.options.store.new.subcategory') }}">

        @csrf

        @php

            $categories_data = $custom_categories->merge($categories);
            $lang = app()->getLocale();

        @endphp

        <dropdown
            :data="{{ json_encode($categories_data) }}"
            :title="{{ json_encode( __('app.create-ponuda.choose-category')) }}"
            :searchtext="{{ json_encode(__('app.create-ponuda.search')) }}"
            :locale="{{ json_encode($lang) }}"
            :inputname="{{ json_encode('category') }}">
        </dropdown>

        <div class="flex w-full flex-col">
            <span class="input-label py-2">{{ __('app.categories.write-name-subcategory') }}:</span>
            <input type="text" name="subcategory_name_sr" class="input-style" id="inputText">

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
