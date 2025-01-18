<x-app-worker-layout>

    <x-slot name="pageTitle">
        {{ __('app.categories.new-category-title') }}
    </x-slot>
    <x-slot name="header">
        {{ __('app.categories.new-category-title') }}
    </x-slot>
    <x-slot name="import">
        <script src="{{ mix('js/vue.js') }}"></script>
    </x-slot>

    @if ($errors->has('category_name_sr'))
        <script>

            Swal.fire({
                title: "{{ $errors->first('category_name_sr') }}",
                icon: "error"
            });

        </script>
    @endif

    <div class="flex w-full mt-5">
        <form method="POST" id="add_new_category" onkeydown="return event.key != 'Enter';" class="mt-20 flex flex-col w-full"
            action="{{ route('worker.options.store.new.category') }}">
            @csrf

            @php

                $work_types = $custom_work_types->merge($work_types);
                $lang = app()->getLocale();

            @endphp

            <dropdown
                :data="{{ json_encode($work_types) }}"
                :title="{{ json_encode( __('app.create-ponuda.choose-work-type')) }}"
                :searchtext="{{ json_encode(__('app.create-ponuda.search')) }}"
                :locale="{{ json_encode($lang) }}"
                :inputname="{{ json_encode('work_type') }}">
            </dropdown>

            <div class="flex w-full flex-col">
                <span class="input-label py-2">{{ __('app.categories.write-name-category') }}:</span>
                <input type="text" name="category_name_sr" class="input-style" id="inputText">
                <button type="submit" class="main-btn mx-auto mt-10">{{ __('app.basic.save') }}</button>
            </div>

        </form>
    </div>

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
