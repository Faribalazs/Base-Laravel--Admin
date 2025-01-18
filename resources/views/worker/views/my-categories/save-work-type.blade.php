<x-app-worker-layout>

    <x-slot name="pageTitle">
        {{ __('app.categories.update-work-type') }}
    </x-slot>
    <x-slot name="header">
        {{ __('app.categories.update-work-type') }}
    </x-slot>

    @if ($errors->has('work_type'))
        <script>

            Swal.fire({
                title: "{{ $errors->first('work_type') }}",
                icon: "error"
            });

        </script>
    @endif

    @php
        $work_type_name = $work_type->name ?? null;
        $work_type_id = $work_type->id ?? null;
    @endphp

    <div class="md:flex hidden w-full justify-end mt-5">
        <button type="button" class="delete-btn-table text-white flex gap-2 py-3 md:text-xl text-lg px-8"
            onclick="actionSwall('{{ route('worker.options.delete.worktype') }}','{{ $work_type_id }}')">
            {{ __('app.categories.delete-work-type') }}
            <i class="ri-delete-bin-line"></i>
        </button>
    </div>

    <div class="mt-3">
        <div class="flex w-full">
            <form method="POST" id="formWorkType" onkeydown="return event.key != 'Enter';" action="{{ route('worker.options.update.worktype') }}"
                class="mt-10 flex flex-col w-full">
                @csrf
                <span class="input-label md:text-xl text-lg py-3">{{ __('app.categories.write-name-work-type') }}:</span>
                @method('PUT')
                <input type="text" value="{{ $work_type_name }}" name="worktype"
                    class="w-full md:text-xl text-lg input-style">
                <input type="hidden" name="id" value="{{ $id }}" class="w-full input-style">
                <button type="submit" class="main-btn mx-auto md:w-1/2 w-full md:text-xl text-lg md:mt-20 mt-12">{{ __('app.basic.save') }}</button>
                <button type="button" class="delete-btn-table text-white flex gap-2 md:text-xl mt-10 py-3 md:hidden text-lg px-8"
                    onclick="actionSwall('{{ route('worker.options.delete.worktype') }}','{{ $work_type_id }}')">
                    {{ __('app.categories.delete-work-type') }}
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
