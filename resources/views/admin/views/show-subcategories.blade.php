<x-admin-app-layout>
    <x-slot name="pageTitle">
        {{ __('app.admin.subcategories') }}
    </x-slot>
    <x-slot name="header">
        {{ __('app.admin.subcategories') }}
    </x-slot>
    <div class="main-container w-full mt-10" style="overflow: auto">
        <button class="add-new-btn mt-3" onclick="insertSwall()">Kreirajte novu podkategoriju</button>
        <table class="table text-center">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Naziv podkategorije</th>
                <th scope="col">Izmeni</th>
                <th scope="col">Izbriši</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($subcategories as $subcategory)
                <tr>
                    <td>{{$subcategory->id}}</td>
                    <td>{{$subcategory->name}}</td>
                    <td onclick="editSwall('{{ $subcategory->id }}', '{{ $subcategory->name }}')">
                        <div class="d-flex justify-content-center">
                            <button class="modositas-btn mr-1">
                                <i class="ri-edit-2-line"></i>
                            </button>
                        </div>
                    </td>
                    <td onclick="deleteSwall('{{ $subcategory->id }}', '{{ $subcategory->name }}')">
                        <button class="torles-btn ml-1">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{ $subcategories->links('pagination::bootstrap-5') }}
        </div>
    </div>
    <script>
        function insertSwall() {
            Swal.fire({
            title: 'Kreirajte novu podkategoriju',
            html: 
                '<form method="POST" id="formnew" action="{{ route('admin.insert.subcategory') }}">' +
                '@csrf' +
                '<label for="category_options">Kategorija:</label>' +
                '<select name="category_options" class="mt-3 form-control">' +
                    @foreach ($categories as $category)
                        '<option value="{{ $category->id }}">{{ $category->name }}</option>'+
                    @endforeach
                '</select>' +
                '<label for="new_subcategory_name">Naziv podkategorije (serbian):</label>' +
                '<input class="mt-3 swal-input" type="text" name="new_subcategory_name"/>' +
                '<label for="new_subcategory_name_en">Naziv podkategorije (english):</label>' +
                '<input class="mt-3 swal-input" type="text" name="new_subcategory_name_en"/>' +
                '<label for="new_subcategory_name_hu">Naziv podkategorije (hungarian):</label>' +
                '<input class="mt-3 swal-input" type="text" name="new_subcategory_name_hu"/>' +
                '<button type="submit" class="add-new-btn mt-3">Insert</button>' +
                '</form>',
            showCancelButton: false,
            showConfirmButton: false,
            showCloseButton: true,
            });
        }
        function editSwall(id, name) {
            Swal.fire({
            title: 'Izmeni podkategorija',
            html: 
                '<form method="POST" id="formDone" action="{{ route('admin.edit.subcategory') }}">' +
                '@csrf' +
                '@method("put")' +
                '<label for="subcategory_name">Naziv podkategorije:</label>' +
                '<input class="mt-3 swal-input" type="text" name="subcategory_name" value="'+name+'"/>' +
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
                title: 'Da li želite da izbrišete podkategoriju '+name+'?',
                icon: 'question',
                html: 
                    '<form method="POST" id="formDelete" action="{{ route('admin.delete.subcategory') }}">' +
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