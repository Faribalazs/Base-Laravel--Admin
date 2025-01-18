<x-admin-app-layout>
    <x-slot name="pageTitle">
        {{ __('app.admin.sections') }}
    </x-slot>
    <x-slot name="header">
        {{ __('app.admin.sections') }}
    </x-slot>
    <div class="main-container w-full mt-10" style="overflow: auto">
        <table class="table text-center">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Stranica</th>
                <th scope="col">Naslov</th>
                <th scope="col">Status</th>
                <th scope="col">Izmeni</th>
                <th scope="col">Izbrisi</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($sections as $section)
                <tr>
                    <td>{{$section->id}}</td>
                    <td>{{$section->page}}</td>
                    <td>{{$section->title}}</td>
                    <td>{{$section->status}}</td>
                    <td>
                        <a href="{{ route('admin.sections.edit', $section->id) }}" class="modositas-btn mr-1">
                            <i class="ri-edit-2-line"></i>
                        </a>
                    </td>
                    <td onclick="deleteSwall('{{ $section->id }}', '{{ $section->title }}')">
                        <button class="torles-btn ml-1">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{ $sections->links('pagination::bootstrap-5') }}
        </div>
    </div>
    <script>
        function deleteSwall(id, name) {
            Swal.fire({
                title: 'Da li želite da izbrišete sekciju '+name+'?',
                icon: 'question',
                html: 
                    '<form method="POST" id="formDelete" action="{{ route('admin.sections.delete') }}">' +
                    '@csrf' +
                    '@method("delete")' +
                    '<input class="mt-3 swal-input" hidden type="text" name="id" value="'+id+'"/>' +
                    '<button type="submit" class="add-new-btn mt-3">Izbriši</button>' +
                    '</form>',
                showCancelButton: false,
                showConfirmButton: false,
                showCloseButton: true,
            });
        }
    </script>
</x-admin-app-layout>