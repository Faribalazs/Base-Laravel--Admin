<x-app-worker-layout>

    <x-slot name="pageTitle">
        {{ __('app.categories.new-work-type-title') }}
    </x-slot>
    <x-slot name="header">
        {{ __('app.categories.new-work-type-title') }}
    </x-slot>
    <x-slot name="import">
        <script src="{{ mix('js/vue.js') }}"></script>
    </x-slot>

    @if ($errors->has('work_type_name_sr'))
        <script>

            Swal.fire({
                title: "{{ $errors->first('work_type_name_sr') }}",
                icon: "error"
            });

        </script>
    @endif

    <div class="flex w-full mt-5">
        <form method="POST" id="add_new_category" onkeydown="return event.key != 'Enter';" class="mt-20 flex flex-col w-full"
            action="{{ route('worker.options.store.new.work-type') }}">
            @csrf
            <span class="input-label py-2">{{ __('app.categories.write-name-work-type') }}:</span>
            <input type="text" name="work_type_name_sr" class="input-style" id="inputText">

            <button type="submit" class="main-btn mx-auto mt-10">{{ __('app.basic.save') }}</button>
        </form>
    </div>

</x-app-worker-layout>
