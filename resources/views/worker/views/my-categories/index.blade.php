<x-app-worker-layout>
    <x-slot name="pageTitle">
        {{ __('app.categories.my-categories') }}
    </x-slot>
    <x-slot name="header">
        {{ __('app.categories.my-categories') }}
    </x-slot>
    <div class="category-container">
        <ul id="categoryUl">
            @foreach ($custom_work_types as $custom_work_type)
                @if (!empty($custom_work_type->id))
                    <li>
                        <div class="flex items-center">
                            @if($custom_work_type->id >= config('app.min_id_custom_work_types'))
                                <a class="mb-1 font-bold hover:underline hover:text-secondary-color" href="{{ route('worker.options.show.worktype', ['work_type' => $custom_work_type->id]) }}">
                                    {{ $custom_work_type->name }}
                                </a>
                            @else
                                {{ $custom_work_type->name }}
                            @endif
                            @if ($custom_categories->where('work_type_id', $custom_work_type->id)->isNotEmpty() || $custom_categories->where('custom_work_type_id', $custom_work_type->id)->isNotEmpty())
                                <span class="caret">
                                    <i class="ri-arrow-right-s-line text-3xl caret-icon"></i>
                                </span>
                            @endif
                        </div>
                        <ul class="nested">
                            @foreach ($custom_categories as $custom_category)
                                @if (!empty($custom_category->id) && ($custom_category->custom_work_type_id == $custom_work_type->id || $custom_category->work_type_id == $custom_work_type->id))
                                    <li>
                                        <div class="flex items-center">
                                            @if($custom_category->id >= config('app.min_id_custom_categories'))
                                                <a class="mb-1 hover:underline hover:text-secondary-color" href="{{ route('worker.options.show.category', ['category' => $custom_category->id]) }}">
                                                    {{ $custom_category->name }}
                                                </a>
                                            @else
                                                {{ $custom_category->name }}
                                            @endif
                                            @if ($custom_subcategories->where('category_id', $custom_category->id)->isNotEmpty() || $custom_subcategories->where('custom_category_id', $custom_category->id)->isNotEmpty())
                                                <span class="caret">
                                                    <i class="ri-arrow-right-s-line text-3xl caret-icon"></i>
                                                </span>
                                            @endif
                                        </div>
                                        <ul class="nested">
                                            @foreach ($custom_subcategories as $custom_subcategory)
                                                @if (!empty($custom_subcategory->id) && ($custom_subcategory->custom_category_id == $custom_category->id || $custom_subcategory->category_id == $custom_category->id))
                                                    <li>
                                                        <div class="flex items-center">
                                                            @if($custom_subcategory->id >= config('app.min_id_custom_subcategories'))
                                                                <a class="mb-1 hover:underline hover:text-secondary-color" href="{{ route('worker.options.show.subcategory', ['subcategory' => $custom_subcategory->id]) }}">
                                                                    {{ $custom_subcategory->name }}
                                                                </a>
                                                            @else
                                                                {{ $custom_subcategory->name }}
                                                            @endif
                                                            @if ($custom_pozicije->where('subcategory_id', $custom_subcategory->id)->isNotEmpty() || $custom_pozicije->where('custom_subcategory_id', $custom_subcategory->id)->isNotEmpty())
                                                                <span class="caret">
                                                                    <i class="ri-arrow-right-s-line text-3xl caret-icon"></i>
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <ul class="nested">
                                                            @foreach ($custom_pozicije as $custom_pozicija)
                                                                @if ($custom_pozicija->custom_subcategory_id == $custom_subcategory->id || $custom_pozicija->subcategory_id == $custom_subcategory->id)
                                                                    <li>
                                                                        <a class="hover:underline hover:text-secondary-color" href="{{ route('worker.options.show.pozicija', ['pozicija' => $custom_pozicija->id]) }}">
                                                                            {{ $custom_pozicija->title ?? $custom_pozicija->title }}
                                                                        </a>
                                                                    </li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    </li>
                                                @elseif ($custom_subcategory->custom_category_id == $custom_category->id)
                                                    <li>
                                                        <a class="hover:underline hover:text-secondary-color" href="{{ route('worker.options.show.subcategory', ['subcategory' => $custom_subcategory->id]) }}">
                                                            {{ $custom_subcategory->name }}
                                                        </a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </li>
                                @elseif ($custom_category->custom_work_type_id == $custom_work_type->id)
                                    <li>
                                        <a class="hover:underline hover:text-secondary-color" href="{{ route('worker.options.show.category', ['category' => $custom_category->id]) }}">
                                            {{ $custom_category->name }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
    <div class="flex items-center flex-col mt-20">
        <div class="mb-10">
            <p class="text-center text-xl font-semibold">
                {{ __('app.categories.choose-option') }}
            </p>
        </div>
        <div>
            <button onclick="addNewOption()" class="main-btn ml-3">
                {{ __('app.categories.dodaj') }}
            </button>
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
                    '<button type="submit" class="add-new-btn mx-1 mt-5">{{ __('app.basic.delete') }}</button>' +
                    '</form>',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location = url;
                }
            })
        }
    </script>
    @if ($successMsg == 'kecske' && Auth::guard('worker')->check())
        <script>
            Swal.fire(
                title: '{{ __('app.controllers.deleted-category') }}',
                icon: 'success',
                confirmButtonText: "{{ __('app.basic.close') }}",
                showConfirmButton: false,
                showCloseButton: true,
                confirmButtonColor: '#22ff00',
                cancelButtonColor: '#d33',
            )
        </script>
    @endif
    @if ($successMsg == 'cica' && !empty($name) && Auth::guard('worker')->check())
        <script>
            Swal.fire(
                '{{ __('app.create-ponuda.cica') }}: {{ $name }}',
                '',
                'info'
            )
        </script>
    @endif
    <script>
        function addNewOption() {
            Swal.fire({
                title: '{{ __('app.categories.what-you-want-to-add') }}',
                icon: 'question',
                html: '<div class="flex flex-col gap-5 pb-6">' +
                    '<a href=\"{{ route('worker.options.create.new.work-type') }}\" class="main-btn">{{ __('app.categories.new-work-type') }}</a>' +
                    '<a href=\"{{ route('worker.options.create.new.category') }}\" class="main-btn">{{ __('app.categories.new-category') }}</a>' +
                    '<a href=\"{{ route('worker.options.create.new.subcategory') }}\" class="main-btn">{{ __('app.categories.new-subcategory') }}</a>' +
                    '<a href=\"{{ route('worker.options.create.new.pozicija') }}\" class="main-btn">{{ __('app.categories.new-pozicija') }}</a>' +
                    '</div>',
                showCancelButton: false,
                showConfirmButton: false,
                showCloseButton: true,
                confirmButtonColor: '#22ff00',
                cancelButtonColor: '#d33',
            })
        }

        var toggler = document.getElementsByClassName("caret");
        var i;

        for (i = 0; i < toggler.length; i++) {
            toggler[i].addEventListener("click", function() {
                this.parentElement.parentElement.querySelector(".nested").classList.toggle("active");
                this.classList.toggle("caret-down");
            });
        }
    </script>

    <style>
        ul,
        #categoryUl {
            list-style-type: none;
        }

        #categoryUl {
            margin: 0;
            padding: 0;
            font-size: 20px;
        }

        #categoryUl li {
            margin-bottom: 8px;
        }

        #categoryUl li:last-child {
            margin-bottom: 0px !important;
        }

        .caret {
            cursor: pointer;
            -webkit-user-select: none;
            /* Safari 3.1+ */
            -moz-user-select: none;
            /* Firefox 2+ */
            -ms-user-select: none;
            /* IE 10+ */
            user-select: none;
        }

        .caret i {
            color: black;
            display: inline-block;
        }

        .caret-down i {
            -ms-transform: rotate(90deg);
            /* IE 9 */
            -webkit-transform: rotate(90deg);
            /* Safari */
            transform: rotate(90deg);
        }

        .nested {
            display: none;
        }

        .nested {
            padding-left: 20px !important;
        }

        .active {
            display: block;
            margin-bottom: 10px;
        }
    </style>
</x-app-worker-layout>
