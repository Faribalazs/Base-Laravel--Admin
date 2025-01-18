<x-worker-profile-layout>
    <x-slot name="pageTitle">
        {{ __("app.profile.my-clients") }}
    </x-slot>
    <x-slot name="header">
    </x-slot>
    <div class="flex profile-title">
        <p class="text-3xl font-bold">{{ __("app.profile.my-clients") }}</p>
    </div>
    <div class="flex mt-10 md:flex-row flex-col md:gap-0 gap-7">
        <div class="flex md:w-1/2 w-full flex-col text-center md:border-r-2 md:border-grey">
            <p class="text-xl font-bold cursor-pointer" onclick="selectFizickoLice()">
                <span id="fizicka_lica"
                    class="{{ \Session::has('selected_pravna') ? '' : 'contact-selected' }}
                    {{ \Session::has('selected_fizicko') ? 'contact-selected' : '' }}">
                    <span>
                        {{ __("app.profile.individual") }}
                    </span>
                    <i class="ri-user-line pl-2"></i>
                </span>
            </p>
        </div>
        <div class="flex md:w-1/2 w-full flex-col text-center">
            <p class="text-xl font-bold cursor-pointer" onclick="selectPravnoLice()">
                <span id="pravna_lica" class="{{ \Session::has('selected_pravna') ? 'contact-selected' : '' }}">
                    <span>
                        {{ __("app.profile.legal-entity") }}
                    </span>
                    <i class="ri-user-2-line pl-2"></i>
                </span>
            </p>
        </div>
    </div>
    <div class="mt-10 flex-col mb-20 {{ \Session::has('selected_pravna') ? 'hide-list' : 'show-list' }} "
        id="fizicka_lica_list">
        @if (count($fizicka_lica) > 0)
            <div class="flex flex-col w-full" id="fizicko_div">
                <input type="text" placeholder="{{ __('app.create-ponuda.search') }}..." id="fizicko_search" onkeyup="filterFizickoLice()"
                    class="w-full dropdown-search mb-3">
                <a href="{{ route('worker.personal.contacts.add.individual') }}">
                    <div class="add-new-contact-btn flex rounded-md justify-center md:text-lg text-base mt-2 py-3 mb-6">
                        {{ __("app.profile.add-individual") }}
                    </div>
                </a>
                <div class="contact-list-search">
                    @foreach ($fizicka_lica as $fizicko_lice)
                        <div style="min-height: max-content"
                            class="flex flex-grow justify-between border-border-grey border rounded-2xl items-center px-7 py-3 mb-3">
                            <span class="option-text-fizicka-lica card-lice-ime">{{ $fizicko_lice->first_name }}
                                {{ $fizicko_lice->last_name }}</span>
                            <div class="flex sm:gap-3 gap-0 sm:pl-4 pl-3">
                                <a href="{{ route('worker.personal.contacts.show', ['lice' => 'individual', 'id' => $fizicko_lice->id]) }}"
                                    class="share-btn-table mr-3">
                                    <i class="ri-eye-line"></i>
                                </a>
                                <a class="edit-btn-table"
                                    href="{{ route('worker.personal.contacts.edit.fizicka', ['id' => $fizicko_lice->id]) }}">
                                    <i class="ri-edit-line"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <a href="{{ route('worker.personal.contacts.add.individual') }}">
                <div class="add-new-contact-btn flex rounded-md justify-center md:text-lg text-base mt-3 w-3/4 py-2 mx-auto">
                    {{ __("app.profile.add-individual") }}
                </div>
            </a>
            <p class="text-xl flex text-center justify-center mt-8">{{ __("app.profile.no-added-individual") }}</p>
        @endif
    </div>

    <div class="mt-10 flex-col mb-20 {{ \Session::has('selected_pravna') ? 'show-list' : 'hide-list' }}"
        id="pravna_lica_list">
        @if (count($pravna_lica) > 0)
            <div class="flex flex-col w-full" id="pravno_div">
                <input type="text" placeholder="{{ __('app.create-ponuda.search') }}..." id="pravno_search" onkeyup="filterPravnoLice()"
                    class="w-full dropdown-search mb-3">
                <a href="{{ route('worker.personal.contacts.add.legal-entity') }}">
                    <div class="add-new-contact-btn flex rounded-md justify-center md:text-lg text-base mt-2 py-3 mb-6">
                        {{ __("app.profile.add-legal-entity") }}
                    </div>
                </a>
                <div class="contact-list-search">
                    @foreach ($pravna_lica as $pravno_lice)
                        <div
                            class="flex justify-between border-border-grey border rounded-2xl items-center px-7 py-3 mb-3">
                            <span class="option-text-fizicka-lica card-lice-ime">{{ $pravno_lice->company_name }}</span>
                            <div class="flex sm:gap-3 gap-0 sm:pl-4 pl-3">
                                <a href="{{ route('worker.personal.contacts.show', ['lice' => 'legal-entity', 'id' => $pravno_lice->id]) }}"
                                    class="share-btn-table mr-3">
                                    <i class="ri-eye-line"></i>
                                </a>
                                <a class="edit-btn-table"
                                    href="{{ route('worker.personal.contacts.edit.pravna', ['id' => $pravno_lice->id]) }}">
                                    <i class="ri-edit-line"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="add-new-contact-btn flex rounded-md justify-center md:text-lg text-base mt-3 w-3/4 py-2 mx-auto">
                <a href="{{ route('worker.personal.contacts.add.legal-entity') }}">
                    {{ __("app.profile.add-legal-entity") }}
                </a>
            </div>
            <p class="text-xl flex text-center justify-center mt-8">{{ __("app.profile.no-added-legal-entity") }}</p>
        @endif
    </div>

    <script>
        function selectFizickoLice() {
            var fizicko_lice = document.querySelector('#fizicka_lica');
            var pravno_lica = document.querySelector('#pravna_lica');
            var fizicka_list = document.querySelector('#fizicka_lica_list');
            var pravna_list = document.querySelector('#pravna_lica_list');
            if (!fizicko_lice.classList.contains("contact-selected")) {
                fizicko_lice.classList.add("contact-selected");
            }
            if (pravno_lica.classList.contains("contact-selected")) {
                pravno_lica.classList.remove("contact-selected");
            }
            if (!fizicka_list.classList.contains("show-list")) {
                fizicka_list.classList.remove("hide-list");
                fizicka_list.classList.add("show-list");
                pravna_list.classList.add("hide-list");
                pravna_list.classList.remove("show-list");
            }
        }

        function selectPravnoLice() {
            var pravno_lica = document.querySelector('#pravna_lica');
            var fizicko_lice = document.querySelector('#fizicka_lica');
            var fizicka_list = document.querySelector('#fizicka_lica_list');
            var pravna_list = document.querySelector('#pravna_lica_list');
            if (!pravno_lica.classList.contains("contact-selected")) {
                pravno_lica.classList.add("contact-selected");
            }
            if (fizicko_lice.classList.contains("contact-selected")) {
                fizicko_lice.classList.remove("contact-selected");
            }
            if (fizicka_list.classList.contains("show-list")) {
                fizicka_list.classList.remove("show-list");
                fizicka_list.classList.add("hide-list");
            }
            if (!pravna_list.classList.contains("show-list")) {
                pravna_list.classList.remove("hide-list");
                pravna_list.classList.add("show-list");
            }
        }

        function filterFizickoLice() {
            var input, filter;
            input = document.getElementById("fizicko_search");
            filter = input.value.toUpperCase();
            div = document.getElementById("fizicko_div");
            a = div.getElementsByTagName("span");
            no = 0;
            no_result = document.getElementById("no_result");
            for (i = 0; i < a.length; i++) {
                txtValue = a[i].textContent || a[i].innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    a[i].parentElement.style.display = "";
                    if (no_result) {
                        no_result.remove();
                    }
                } else {
                    a[i].parentElement.style.display = "none";
                    no += 1;
                }
            }
            if (a.length == no && !no_result) {
                p = document.createElement("p");
                p.id = 'no_result';
                p.innerHTML = '{{ __("app.profile.no-such-contact") }}';
                div.append(p);
            }
        }

        function filterPravnoLice() {
            var input, filter;
            input = document.getElementById("pravno_search");
            filter = input.value.toUpperCase();
            div = document.getElementById("pravno_div");
            a = div.getElementsByTagName("span");
            no = 0;
            no_result = document.getElementById("no_result");
            for (i = 0; i < a.length; i++) {
                txtValue = a[i].textContent || a[i].innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    a[i].parentElement.style.display = "";
                    if (no_result) {
                        no_result.remove();
                    }
                } else {
                    a[i].parentElement.style.display = "none";
                    no += 1;
                }
            }
            if (a.length == no && !no_result) {
                p = document.createElement("p");
                p.id = 'no_result';
                p.innerHTML = '{{ __("app.profile.no-such-contact") }}';
                div.append(p);
            }
        }
    </script>
</x-worker-profile-layout>
