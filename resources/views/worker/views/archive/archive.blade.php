<x-app-worker-layout>
    <x-slot name="pageTitle">
        {{ __('app.nav.archive') }}
    </x-slot>
    <x-slot name="header">
        {{ __('app.nav.archive') }}
    </x-slot>
    @php
        $i = 1;
        $ponuda_ct = -1;
        $title = '';
        $collection = collect($data);
        $note = $collection->groupBy('id_category');
        if(app()->getLocale() == "rs-cyrl")
        {
            \Carbon\Carbon::setLocale("sr_RS");
        }
        else {
            \Carbon\Carbon::setLocale(app()->getLocale());
        }
    @endphp
    <div class="flex mt-16 filter-search-div">
        <form method="GET" action="{{ route('worker.archive.search') }}" class="">
            @if (isset($search_data))
                <input type="text" name="query" value="{{ $search_data }}" placeholder="{{ __('app.archive.search-name') }}..."
                    id="search-input">
                <button type="button" onclick="searchIcon()" class="my-3 search-icon-div" id="close">
                    <a href="{{ route('worker.archive') }}">
                        <i class="ri-close-line"></i>
                    </a>
                </button>
                <button type="submit" class="my-3 search-icon hidden" id="search">
                    <i class="ri-search-2-line"></i>
                </button>
            @else
                <input type="text" name="query" placeholder="{{ __('app.archive.search-name') }}..." id="search-input">
                <button type="submit" class="my-3 search-icon">
                    <i class="ri-search-2-line"></i>
                </button>
            @endif
        </form>

        <form method="GET" action="{{ route('worker.archive.search.napomena') }}" class="">
            @if (isset($search_data_napomena))
                <input type="text" name="query" value="{{ $search_data_napomena }}"
                    placeholder="{{ __('app.archive.search-note') }}..." id="search_input_napomena">
                <button type="button" onclick="searchIconNapomena()" class="my-3 search-icon-div" id="close_napomena">
                    <a href="{{ route('worker.archive') }}">
                        <i class="ri-close-line"></i>
                    </a>
                </button>
                <button type="submit" class="my-3 search-icon hidden" id="search_napomena">
                    <i class="ri-search-2-line"></i>
                </button>
            @else
                <input type="text" name="query" placeholder="{{ __('app.archive.search-note') }}..." id="search_input_napomena">
                <button type="submit" class="my-3 search-icon">
                    <i class="ri-search-2-line"></i>
                </button>
            @endif
        </form>

        <form method="GET" action="{{ route('worker.archive.search') }}" class="items-center flex">
            <div class="select-menu-archive">
                <div class="select-btn-archive">
                    @if (isset($sort))
                        @if ($sort == 'asc')
                            <span class="sBtn-text-archive">{{ __('app.archive.oldest') }}</span>
                        @endif
                        @if ($sort == 'desc')
                            <span class="sBtn-text-archive">{{ __('app.archive.newest') }}</span>
                        @endif
                    @else
                        <span class="sBtn-text-archive">{{ __('app.archive.sort') }}</span>
                    @endif
                    <i class="ri-arrow-down-s-line"></i>
                </div>
                <ul class="options-archive">
                    @if (isset($sort))
                        <a href="{{ route('worker.archive') }}" class="clear-filter">
                            <li class="option-archive">
                                {{ __('app.archive.delete-filter') }}
                            </li>
                        </a>
                    @endif
                    <li class="option-archive">
                        <button class="option-text-archive" type="submit">{{ __('app.archive.newest') }}</button>
                    </li>
                    <li class="option-archive">
                        <button class="option-text-archive" type="submit">{{ __('app.archive.oldest') }}</button>
                    </li>
                </ul>
            </div>

            <div id="filter-div" class="hidden">
            </div>
        </form>
    </div>
    @if ($data->isNotEmpty())
        <div class="flex mt-8 flex-col justify-start">
            @foreach ($data as $ponuda)
                <div class=" justify-between items-center flex p-3 archive-container my-2">
                    <a href="{{ route('worker.archive.selected', ['id' => $ponuda->id_ponuda]) }}" class="flex w-full">
                        <div class="w-full">
                            {{ __('app.archive.name') }}: <b>{{ $ponuda->ponuda_name }}</b>
                            <p>
                                {{ __('app.archive.created') }} : <b>{{ $ponuda->created_at->translatedFormat('jS F Y H:i') }}</b>
                            </p>
                            @if (isset($ponuda->updated_at))
                                <p>
                                    {{ __('app.archive.updated') }} : {{ $ponuda->updated_at->translatedFormat('jS F Y H:i') }}
                                </p>
                            @endif
                            @if (isset($ponuda->note))
                                <p class="mt-3">
                                    {{ __('app.archive.description') }} : <pre><b>{{  $ponuda->note  }}</b></pre>
                                </p>
                            @endif
                        </div>
                    </a>
                    <div class="w-full archive-hr-mobile">
                        <hr class="w-full my-3">
                    </div>
                    <div class="flex">
                        <a href="{{ route('worker.archive.selected', ['id' => $ponuda->id_ponuda]) }}" class="edit-btn-table mr-3">
                            <i class="ri-edit-line"></i>
                        </a>
                        <a class="share-btn-table mr-3 mobile-show"
                            href="{{ route('worker.archive.view.pdf', ['id' => $ponuda->id_ponuda]) }}">
                            <i class="ri-eye-line"></i>
                        </a>
                        <a class="share-btn-table mr-3 destop-show" target="_blank"
                            href="{{ route('worker.archive.view.pdf', ['id' => $ponuda->id_ponuda]) }}">
                            <i class="ri-eye-line"></i>
                        </a>
                        <button class="delete-btn-table"
                            onclick="actionSwall('{{ route('worker.archive.delete') }}','{{ $ponuda->ponuda_name }}','{{ $ponuda->id_ponuda }}')">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-2xl flex w-full mt-36">
            <span class="w-full text-center">
                {{ __('app.archive.offer-not-found') }}&nbsp;!
            </span>
        </div>
    @endif
    <script>
        function actionSwall(url, name, id) {
            Swal.fire({
                title: '{{ __('app.create-ponuda.swal-are-you-sure-delete') }} "' + name + '"?',
                icon: 'question',
                html: '<form method="POST" id="delElement" action="'+url+'">' +
                    '@csrf' +
                    '@method("delete")' +
                    '<input name="id" hidden value="' + id + '">' +
                    '<button type="submit" class="add-new-btn mx-1 mt-5">{{ __('app.basic.delete') }}</button>' +
                    '</form>',
                showCancelButton: false,
                showConfirmButton: false,
                showCloseButton: true,
            })
        }

        function updateSwall(url, name) {
            Swal.fire({
                title: '{{ __('app.archive.swal-are-you-sure-change') }} "' + name + '"?',
                icon: 'question',
                confirmButtonText: "Izmeni",
                cancelButtonText: "Nazad",
                showConfirmButton: true,
                showCancelButton: true,
                showCloseButton: true,
                confirmButtonColor: '#22ff00',
                cancelButtonColor: '#d33',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location = url;
                }
            })
        }

        const optionMenu = document.querySelector(".select-menu-archive"),
            selectBtn = optionMenu.querySelector(".select-btn-archive"),
            options = optionMenu.querySelectorAll(".option-archive"),
            sBtn_text = optionMenu.querySelector(".sBtn-text-archive");

        selectBtn.addEventListener("click", () =>
            optionMenu.classList.toggle("active")
        );

        options.forEach((option) => {
            option.addEventListener("click", () => {
                let selectedOption = option.querySelector(".option-text-archive").innerText;
                sBtn_text.innerText = selectedOption;
                var existInput = document.getElementById("filter");
                var div = document.getElementById("filter-div");
                if (existInput) {
                    existInput.remove();
                }
                var input = document.createElement("input");
                input.id = "filter";
                input.name = "sort_order";
                input.type = "text";
                if (selectedOption == "{{ __('app.archive.oldest') }}") {
                    input.defaultValue = "asc";
                    input.value = "asc";
                } else {
                    input.defaultValue = "desc";
                    input.value = "desc";
                }
                div.appendChild(input);

                optionMenu.classList.remove("active");
            });
        });

        function searchIcon() {
            var close = document.getElementById("close");
            var search = document.getElementById("search");
            var searchInput = document.getElementById("search-input");
            close.style.display = "none";
            searchInput.value = "";
            search.style.display = "initial";
        }

        function searchIconNapomena() {
            var close = document.getElementById("close_napomena");
            var search = document.getElementById("search_napomena");
            var searchInput = document.getElementById("search_input_napomena");
            close.style.display = "none";
            searchInput.value = "";
            search.style.display = "initial";
        }
    </script>
</x-app-worker-layout>
