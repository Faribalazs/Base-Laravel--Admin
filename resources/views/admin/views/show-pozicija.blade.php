<x-admin-app-layout>
    <x-slot name="pageTitle">
        {{ __('app.admin.pozicije') }}
    </x-slot>
    <x-slot name="header">
        {{ __('app.admin.pozicije') }}
    </x-slot>
    <div class="main-container w-full mt-10" style="overflow: auto">
        <button class="add-new-btn mt-3" onclick="insertSwall()">Kreirajte novu poziciju</button>
        <table class="table text-center">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Naziv pozicija</th>
                <th scope="col">Opis pozicija</th>
                <th scope="col">Jedinica pozicija</th>
                <th scope="col">Izmeni</th>
                <th scope="col">Izbriši</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($pozicija as $poz)
                <tr>
                    <td>{{$poz->id}}</td>
                    <td>{{$poz->title}}</td>
                    <td>{{$poz->description}}</td>
                    <td>{{$poz->unit->name}}</td>
                    <td onclick="editSwall('{{ $poz->id }}', '{{ $poz->title }}', '{{ $poz->description }}', '{{ $poz->unit->id_unit }}')">
                        <div class="d-flex justify-content-center">
                            <button class="modositas-btn mr-1">
                                <i class="ri-edit-2-line"></i>
                            </button>
                        </div>
                    </td>
                    <td onclick="deleteSwall('{{ $poz->id }}', '{{ $poz->title }}')">
                        <button class="torles-btn ml-1">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{ $pozicija->links('pagination::bootstrap-5') }}
    </div>
    <script>
        function insertSwall() {
            Swal.fire({
            title: 'Kreirajte novu poziciju',
            html: 
                '<form method="POST" id="formnew" action="{{ route('admin.insert.pozicija') }}">' +
                '@csrf' +
                '<label for="subcategory_options">Subcategory:</label>' +
                '<select name="subcategory_options" class="mt-3 form-control">' +
                    @foreach ($subcategories as $subcategory)
                        '<option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>'+
                    @endforeach
                '</select>' +
                '<label for="new_title">Naziv pozicija (serbian):</label>' +
                '<input class="mt-3 swal-input" type="text" name="new_title"/>' +
                '<label for="new_description">Opis pozicija (serbian):</label>' +
                '<textarea class="mt-3 swal-input" rows="4" cols="50" type="text" name="new_description"></textarea>'+
                '<label for="new_title_en">Naziv pozicija (english):</label>' +
                '<input class="mt-3 swal-input" type="text" name="new_title_en"/>' +
                '<label for="new_description_en">Opis pozicija (english):</label>' +
                '<textarea class="mt-3 swal-input" rows="4" cols="50" type="text" name="new_description_en"></textarea>'+
                '<label for="new_title_hu">Naziv pozicija (hungarian):</label>' +
                '<input class="mt-3 swal-input" type="text" name="new_title_hu"/>' +
                '<label for="new_description_hu">Opis pozicija (hungarian):</label>' +
                '<textarea class="mt-3 swal-input" rows="4" cols="50" type="text" name="new_description_hu"></textarea>'+
                '<label for="unit_options">Jedinica:</label>' +
                '<select name="unit_options" class="mt-3 form-control">' +
                    @foreach ($units as $unit)
                        '<option value="{{ $unit->id_unit }}">{{ $unit->name }}</option>'+
                    @endforeach
                '</select>' +
                '<button type="submit" class="add-new-btn mt-3">Kreiraj</button>' +
                '</form>',
            showCancelButton: false,
            showConfirmButton: false,
            showCloseButton: true,
            });
        }
        
        function editSwall(id, title, description, unit) {
            Swal.fire({
            title: 'Izmeni pozicija',
            html: 
                '<form method="POST" id="formDone" action="{{ route('admin.edit.pozicija') }}">' +
                '@csrf' +
                '@method("put")' +
                '<label for="title">Naziv pozicija:</label>' +
                '<input class="mt-3 swal-input" type="text" name="title" value="'+title+'"/>' +
                '<label for="description" class="mt-3">Opis:</label>' +
                '<textarea class="mt-3 swal-input" rows="4" cols="50" type="text" name="description">' +description + '</textarea>' +
                '<label for="unit">Jedinica:</label>' +
                '<select name="unit" class="mt-3 form-control">' +
                    @foreach ($units as $unit)
                        '<option value="{{ $unit->id_unit }}"' + (unit == {{ $unit->id_unit }} ? 'selected' : '') + '>{{ $unit->name }}</option>'+
                    @endforeach
                '</select>' +
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
                title: 'Da li želite da izbrišete poziciju '+name+'?',
                icon: 'question',
                html: 
                    '<form method="POST" id="formDelete" action="{{ route('admin.delete.pozicija') }}">' +
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

