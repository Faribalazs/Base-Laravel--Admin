<x-admin-app-layout>
    <x-slot name="pageTitle">
        {{ __('app.admin.categories') }}
    </x-slot>
    <x-slot name="header">
        {{ __('app.admin.categories') }}
    </x-slot>
    <div class="main-container w-full mt-10" style="overflow: auto">
        <button class="add-new-btn mt-3" onclick="insertSwall()">Kreirajte novu kategoriju</button>
        <table class="table text-center w-full">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Naziv kategorija</th>
                <th scope="col">Izmeni</th>
                <th scope="col">Izbriši</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td>{{$category->id}}</td>
                    <td>{{$category->name}}</td>
                    <td onclick="editSwall('{{ $category->id }}', '{{ $category->name }}')">
                        <div class="d-flex justify-content-center">
                            <button class="modositas-btn mr-1">
                                <i class="ri-edit-2-line"></i>
                            </button>
                        </div>
                    </td>
                    <td onclick="deleteSwall('{{ $category->id }}', '{{ $category->name }}')">
                        <button class="torles-btn ml-1">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{ $categories->links('pagination::bootstrap-5') }}
        </div>
    </div>
    <script>
        function insertSwall() {
            Swal.fire({
            title: 'Kreirajte novu kategoriju',
            html: 
                '<form method="POST" id="formnew" action="{{ route('admin.insert.category') }}">' +
                '@csrf' +
                '<label for="new_category_name">Naziv kategorija (serbian):</label>' +
                '<input class="mt-3 swal-input" type="text" name="new_category_name"/>' +
                '<label for="new_category_name_en">Naziv kategorija (english):</label>' +
                '<input class="mt-3 swal-input" type="text" name="new_category_name_en"/>' +
                '<label for="new_category_name_hu">Naziv kategorija (hungarian):</label>' +
                '<input class="mt-3 swal-input" type="text" name="new_category_name_hu"/>' +
                '<button type="submit" class="add-new-btn mt-3">Kreiraj</button>' +
                '</form>',
            showCancelButton: false,
            showConfirmButton: false,
            showCloseButton: true,
            });
        }
        function editSwall(id, name) {
            Swal.fire({
            title: 'Izmeni kategorija',
            html: 
                '<form method="POST" id="formDone" action="{{ route('admin.edit.category') }}">' +
                '@csrf' +
                '@method("put")' +
                '<label for="category_name">Naziv kategorija:</label>' +
                '<input class="mt-3 swal-input" type="text" name="category_name" value="'+name+'"/>' +
                '<input class="mt-3 swal-input" hidden type="text" name="id" value="'+id+'"/>' +
                '<button type="submit" class="add-new-btn mt-3">Izmeni</button>' +
                '</form>',
            showCancelButton: false,
            showConfirmButton: false,
            showCloseButton: true,
            });
        }
        function deleteSwall(id, name) {
            Swal.fire({
                title: 'Želite li da izbrišete kategoriju '+name+'?',
                icon: 'question',
                html: 
                    '<form method="POST" id="formDelete" action="{{ route('admin.delete.category') }}">' +
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