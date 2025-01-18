<x-admin-app-layout>
    <x-slot name="pageTitle">
        {{ __('app.admin.workers') }}
    </x-slot>
    <x-slot name="header">
        {{ __('app.admin.workers') }}
    </x-slot>
    <div class="main-container w-full mt-10" style="overflow: auto">
        <table class="table text-center">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Ime</th>
                <th scope="col">Email</th>
                <th scope="col">Kreirane ponude</th>
                <th scope="col">Status</th>
                <th scope="col">Ban</th>
                <th scope="col">Unban</th>
                <th scope="col">Oduzmi premiju</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr>
                    @php
                        $name = $user->first_name.' '.$user->last_name;
                    @endphp
                    <td>{{$user->id}}</td>
                    <td>{{$name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->ponuda_counter}}</td>
                    <td>@if($user->status == 1) Aktivan @else Zabranjen @endif</td>
                    <td onclick="BanSwall('{{ $user->id }}', '{{ $name }}')">
                        <div class="d-flex justify-content-center">
                            <button class="modositas-btn mr-1">
                                <i class="ri-edit-2-line"></i>
                            </button>
                        </div>
                    </td>
                    <td onclick="unBanSwall('{{ $user->id }}', '{{ $name }}')">
                        <button class="torles-btn ml-1">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </td>
                    <td onclick="demotePremiumSwall('{{ $user->id }}', '{{ $name }}')">
                        <button>
                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1v12m0 0 4-4m-4 4L1 9"/>
                            </svg>
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{ $users->links('pagination::bootstrap-5') }}
        </div>
    </div>
    <script>
        function unBanSwall(id, name) {
            Swal.fire({
                title: 'Da li želite da opozovete zabranu '+name+'?',
                icon: 'question',
                html: 
                    '<form method="POST" id="formUnban" action="{{ route('admin.unban.worker') }}">' +
                    '@csrf' +
                    '@method("put")' +
                    '<input class="mt-3 swal-input" hidden type="text" name="id" value="'+id+'"/>' +
                    '<button type="submit" class="add-new-btn mt-3">Unban</button>' +
                    '</form>',
                showCancelButton: false,
                showConfirmButton: false,
                showCloseButton: true,
            });
        }
        function BanSwall(id, name) {
            Swal.fire({
                title: 'Želite li zabraniti '+name+'?',
                icon: 'question',
                html: 
                    '<form method="POST" id="formBan" action="{{ route('admin.ban.worker') }}">' +
                    '@csrf' +
                    '@method("put")' +
                    '<input class="mt-3 swal-input" hidden type="text" name="id" value="'+id+'"/>' +
                    '<button type="submit" class="add-new-btn mt-3">Ban</button>' +
                    '</form>',
                showCancelButton: false,
                showConfirmButton: false,
                showCloseButton: true,
            });
        }

        function demotePremiumSwall(id, name) {
            Swal.fire({
                title: 'Želite li oduzmite premiju od '+name+'?',
                icon: 'question',
                html: 
                    '<form method="POST" action="{{ route('admin.demote.worker') }}">' +
                    '@csrf' +
                    '<input class="mt-3 swal-input" hidden type="text" name="id" value="'+id+'"/>' +
                    '<button type="submit" class="add-new-btn mt-3">Oduzmi premiju</button>' +
                    '</form>',
                showCancelButton: false,
                showConfirmButton: false,
                showCloseButton: true,
            });
        }
    </script>
</x-admin-app-layout>