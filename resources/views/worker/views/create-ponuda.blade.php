<x-app-worker-layout>
    <x-slot name="pageTitle">
        @if (isset($swap[0]))
            {{ __('app.create-ponuda.edit-title') }}
        @else
            {{ __('app.create-ponuda.create-title') }}
        @endif
    </x-slot>
    <x-slot name="header">
        @if (isset($swap[0]))
            {{ __('app.create-ponuda.edit-title') }}
        @else
            {{ __('app.create-ponuda.create-title') }}
        @endif
    </x-slot>
    <x-slot name="import">
        <script src="{{ mix('js/vue.js') }}"></script>
    </x-slot>
    @php
        $finalPrice = 0;
        $titleBold = 0;
        $subPrice = 0;
        $tempPonudaName = null;
        $tempOpis = null;
        $tempNote = null;
        $finished_note = null;
        $uniqueName = [];
    @endphp
    @foreach ($swap as $s)
        @php
            $tempPonudaName = $s->temp_ponuda_name;
            $tempOpis = $s->temp_opis;
            $tempNote = $s->temp_note;
        @endphp
    @endforeach
    @if (Session::has('msg'))
        <script>
            Swal.fire({
                title: '{{ __('app.basic.successfully-added') }}',
                icon: 'success',
                showCancelButton: true,
                showConfirmButton: true,
                confirmButtonText: "{{ __('app.create-ponuda.swal-add-new-pozicija') }}",
                cancelButtonText: "{{ __('app.create-ponuda.swal-finish-ponuda') }}",
                reverseButtons: true,
                allowEscapeKey: false,
                allowOutsideClick: false,
                allowEnterKey: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    setTimeout(scrollDown, 200);
                }
                if (result.isDismissed) {
                    EndPonuda('{{ $tempPonudaName }}');
                }
            })
        </script>
        @php
            Session::forget('msg');
        @endphp
    @endif
    @if ($mergedData->isNotEmpty())
        @php
            $finalData = $mergedData->sortBy('id')->groupBy('work_type_id');
            $work_type = '';
        @endphp
        <div class="overflow-x-auto">
            @foreach ($finalData as $data)
                <table class="table mt-7 text-center ponuda-table">
                    <thead>
                        @php
                            $sumWorkType = 0;
                            $work_type_pozicija = collect([]);
                            $name_work_type = $data->first()->work_type_name != null ? $data->first()->work_type_name : ($data->first()->custom_work_type_name != null ? $data->first()->custom_work_type_name : '');
                            $work_type = $name_work_type;
                            foreach ($data as $d) {
                                $sumWorkType += $d->unit_price * $d->quantity;
                            }
                        @endphp
                        <tr>
                            <td colspan="8" class="text-left border-bold p-1"
                                style="background-color: rgba(0, 0, 0, 0.15);">
                                <b>{{ $name_work_type }}</b>
                            </td>
                        </tr>
                        @foreach ($data->sortBy('id')->groupBy('categories_id') as $groupbyCat)
                            @php
                                $subPrice = 0;
                                $i = 1;
                            @endphp
                            @foreach ($groupbyCat as $item)
                                @php
                                    $name_category = $item->name_category != null ? $item->name_category : ($item->name_custom_category != null ? $item->name_custom_category : '');
                                    $title = $item->temporary_title != null ? $item->temporary_title : ($item->title != null ? $item->title : ($item->custom_title != null ? $item->custom_title : ''));
                                    $desc_now = $item->temporary_description != null ? $item->temporary_description : ($item->description != null ? $item->description : ($item->custom_description != null ? $item->custom_description : ''));
                                    $desc_now = $desc_now === '&nbsp;' ? '' : $desc_now;
                                    $work_type_pozicija->push($name_category);
                                @endphp
                                @if ($name_category != null && !in_array($name_category, $uniqueName))
                                    <tr>
                                        <td colspan="8" class="text-left border-bold p-1"
                                            style="background-color: rgba(0, 0, 0, 0.05);">
                                            <b>{{ $name_category }}</b>
                                            @php
                                                $uniqueName[] = $name_category;
                                            @endphp
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="p-2 lowercase" scope="col">
                                            {{ __('app.create-ponuda.table-r-br') }}
                                        </th>
                                        <th class="p-2 lowercase" scope="col">
                                            {{ __('app.create-ponuda.table-naziv') }}
                                        </th>
                                        <th class="p-2 px-6 lowercase" scope="col">
                                            {{ __('app.create-ponuda.table-j-m') }}
                                        </th>
                                        <th class="p-2 px-6 lowercase" scope="col">
                                            {{ __('app.create-ponuda.table-kolicina') }}
                                        </th>
                                        <th class="p-2 px-6 lowercase" scope="col">
                                            {{ __('app.create-ponuda.table-jed-cena') }}
                                        </th>
                                        <th class="p-2 px-6 lowercase" scope="col">
                                            {{ __('app.create-ponuda.table-ukupno') }}
                                        </th>
                                        <th class="p-2 px-3 lowercase" scope="col">
                                            {{ __('app.create-ponuda.table-izmeni') }}
                                        </th>
                                        <th class="p-2 px-3 lowercase" scope="col">
                                            {{ __('app.create-ponuda.table-izbrisi') }}
                                        </th>
                                    </tr>
                    </thead>
            @endif
            @php
                $overall_price = $item->quantity * $item->unit_price;
                $subPrice += $overall_price;
            @endphp
            <tbody>
                <tr>
                    <td class="text-center">{{ $i++ }}</td>
                    <td class="text-left ponuda-table-des p-1"><b>
                            {{ $title }}
                        </b><br>
                        {{ $desc_now }}
                        <br>{{ $item->name_service }}
                    </td>
                    <td class="text-center">{{ $item->unit_name }}</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-center lg:px-4 px-3">
                        {{ number_format($item->unit_price, 2) }}&nbsp;{{ __('app.create-ponuda.table-rsd') }}
                    </td>
                    <td class="whitespace-nowrap lg:px-4 px-3 border-left text-center">
                        {{ number_format($overall_price, 2) }}&nbsp;{{ __('app.create-ponuda.table-rsd') }}
                    </td>
                    <td>
                        <button class="edit-btn-table mx-auto"
                            onclick="UpdateSwall(() => ({ realId: {{ $item->id }}, tempDesc: '{{ $desc_now }}', tempTitle: '{{ $title }}', quantity: '{{ $item->quantity }}', unit_price: '{{ $item->unit_price }}', radioBtn: '{{ $item->service_id }}' }))">
                            <i class="ri-edit-line"></i>
                        </button>
                    </td>
                    <td>
                        <button class="delete-btn-table mx-auto"
                            onclick="actionSwall('{{ route('worker.store.new.ponuda.delete') }}','{{ $title }}',{{ $item->id }})">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </td>
                </tr>

                @if ($loop->last)
                    <tr>
                        <td colspan="8" class="text-right border-bold whitespace-nowrap p-1"
                            style="background-color: rgba(0, 0, 0, 0.05);">
                            <b>
                                {{ __('app.create-ponuda.table-svega') }}&nbsp;
                                <span class="lowercase">{{ $name_category }}</span>:
                            </b>&nbsp;{{ number_format($subPrice, 2) }}&nbsp;
                            {{ __('app.create-ponuda.table-rsd') }}
                        </td>
                    </tr>
                @endif
    @endforeach
    @if ($loop->last)
        <tr>
            <td colspan="8" class="text-right border-bold whitespace-nowrap p-1"
                style="background-color: rgba(0, 0, 0, 0.15);">
                <b>
                    {{ __('app.create-ponuda.table-svega') }}&nbsp;
                    <span class="lowercase">{{ $work_type }}</span>:
                </b>&nbsp;{{ number_format($sumWorkType, 2) }}&nbsp;
                {{ __('app.create-ponuda.table-rsd') }}
            </td>
        </tr>
    @endif
    @endforeach
    </tbody>
    </table>
    @endforeach
    <div>
        <table class="ponuda-table mt-5">
            <tbody>
                <tr>
                    <td colspan="8" class="text-left border-bold p-1" style="background-color: rgba(0, 0, 0, 0.05);">
                        <b>
                            {{ __('app.create-ponuda.table-rekapitulacija') }}
                        </b>
                    </td>
                </tr>
                @foreach ($mergedData->sortBy('id')->groupBy('work_type_id') as $data)
                    @php
                        $subPrice = 0;
                    @endphp
                    @foreach ($data as $rekapitulacija)
                        @php
                            $work_type_rekapitulacija = $rekapitulacija->work_type_name != null ? $rekapitulacija->work_type_name : ($rekapitulacija->custom_work_type_name != null ? $rekapitulacija->custom_work_type_name : null);
                            $subPrice += $rekapitulacija->quantity * $rekapitulacija->unit_price;
                        @endphp
                        @if ($loop->last)
                            <tr>
                                <td class="text-left w-full p-1">
                                    {{ $work_type_rekapitulacija }}&nbsp;
                                </td>
                                <td class="p-1 text-center whitespace-nowrap">
                                    {{ number_format($subPrice, 2) }}&nbsp;{{ __('app.create-ponuda.table-rsd') }}
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    @php
                        $finalPrice += $subPrice;
                    @endphp
                @endforeach
            </tbody>
        </table>
    </div>
    <div>
        <table class="table mt-20 text-center ponuda-table w-full mb-7">
            <tr>
                <td class="text-right p-1">
                    <b>{{ __('app.create-ponuda.table-ukupno') }}:
                        {{ number_format($finalPrice, 2) }}&nbsp;{{ __('app.create-ponuda.table-rsd') }}</b>
                </td>
            </tr>
            <tr>
                <td class="text-right p-1">
                    @php
                        $pdv = $finalPrice * 0.2;
                    @endphp
                    {{ __('app.create-ponuda.table-pdv') }}: {{ number_format($pdv, 2) }}
                    {{ __('app.create-ponuda.table-rsd') }}
                </td>
            </tr>
            <tr>
                <td class="text-right p-1">
                    @php
                        $final = $pdv + $finalPrice;
                    @endphp
                    <b>{{ __('app.create-ponuda.table-ukupno-sa-pdv') }}: {{ number_format($final, 2) }}
                        {{ __('app.create-ponuda.table-rsd') }}</b>
                </td>
            </tr>
        </table>
    </div>
    </div>
    @endif
    <form method="POST" id="form" action="{{ route('worker.store.new.ponuda') }}">
        @csrf

        @if ($mergedData->isNotEmpty())
            @if (isset($tempOpis))
                <div class="flex flex-col">
                    <label for="opis" class="mt-3">{{ __('app.create-ponuda.opis-label') }}:</label>
                    <textarea class="mt-3 swal-input" id="opis" rows="6" cols="50" type="text" name="opis">{{ $tempOpis }}</textarea>
                </div>
            @else
                <div class="mb-4">
                    <button onclick="showDes()" type="button" id="yes-des"
                        class="finish-btn my-3 {{ session('opis_ponude') != '' ? 'hidden' : 'flex' }}">{{ __('app.create-ponuda.opis-btn-add') }}</button>
                    <button onclick="hideDes()" type="button" id="nope-des"
                        class="finish-btn my-3 {{ session('opis_ponude') != '' ? 'flex' : 'hidden' }}"
                        style="background-color: #ac1902;">{{ __('app.create-ponuda.opis-btn-remove') }}</button>
                    <div class="flex-col {{ session('opis_ponude') != '' ? 'flex' : 'hidden' }}" id="text-area">
                        <label for="opis" class="mt-3">{{ __('app.create-ponuda.opis-label') }}:</label>
                        <textarea class="mt-3 swal-input" id="opis" rows="6" cols="50" type="text" name="opis">{{ session('opis_ponude') }}</textarea>
                    </div>
                </div>
            @endif
        @endif

        @php
            $workTypesJson = $work_types->merge($custom_work_types);
            $lang = app()->getLocale();
            $url = config('app.url');
            $workerId = auth()->id();
        @endphp

        {{-- Form dropdowns start --}}

        <new-ponuda :worktypes="{{ json_encode($workTypesJson) }}" :locale="{{ json_encode($lang) }}"
            :worktypesplaceholder="{{ json_encode(__('app.create-ponuda.choose-work-type')) }}"
            :categoryplaceholder="{{ json_encode(__('app.create-ponuda.choose-category')) }}"
            :nocategory="{{ json_encode(__('app.create-ponuda.no-category')) }}"
            :subcategoryplaceholder="{{ json_encode(__('app.create-ponuda.choose-subcategory')) }}"
            :pozicijaplaceholder="{{ json_encode(__('app.create-ponuda.choose-pozicija')) }}"
            :materialpricetitle="{{ json_encode(__('app.create-ponuda.price-with-material-title')) }}"
            :materialpricewithmaterial="{{ json_encode(__('app.create-ponuda.price-with-material')) }}"
            :materialpricewithnomaterial="{{ json_encode(__('app.create-ponuda.price-without-material')) }}"
            :pricetitle="{{ json_encode(__('app.create-ponuda.price-rsd')) }}"
            :desdeletebtn="{{ json_encode(__('app.create-ponuda.izbrisi')) }}"
            :unitqtytitle="{{ json_encode(__('app.create-ponuda.upisi-kolicinu')) }}"
            :finishbtntext="{{ json_encode(__('app.create-ponuda.add-pozicija-btn')) }}"
            :searchtext="{{ json_encode(__('app.create-ponuda.search')) }}" :url="{{ json_encode($url) }}"
            :workerid="{{ json_encode($workerId) }}">
        </new-ponuda>

        {{-- Form dropdowns end --}}

    </form>
    @if ($mergedData->isNotEmpty())
        @php
            if (isset($tempNote)) {
                $finished_note = preg_replace('~^"?(.*?)"?$~', '$1', json_encode($tempNote, JSON_HEX_TAG));
            }
        @endphp
        <div class="flex w-full justify-center mt-5">
            <div class="flex" id="end">
                <button onclick="EndPonuda('{{ $tempPonudaName }}')"
                    class="finish-btn my-3">{{ __('app.create-ponuda.finish-ponuda-btn') }}</button>
            </div>
        </div>
    @endif
    @if (session('accessDenied'))
        <script>
            Swal.fire({
                title: "{{ __('app.create-ponuda.swal-access-denied') }}",
                text: "{{ session('accessDenied') }}",
                icon: 'error',
                confirmButtonColor: '#d33'
            });
        </script>
    @endif
    <script>
        function scrollDown() {
            var element = document.querySelector(".select-menu-work-type");
            element.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
        }

        function showDes() {
            var x = document.getElementById("text-area");
            var y = document.getElementById("nope-des");
            var z = document.getElementById("yes-des");
            if (x.classList.contains('hidden')) {
                x.classList.remove('hidden');
                x.classList.add('flex');
                y.classList.remove('hidden');
                y.classList.add('flex');
                z.classList.remove('flex');
                z.classList.add('hidden');
            } else {
                x.classList.remove('flex');
                x.classList.add('hidden');
            }
        }

        function hideDes() {
            var x = document.getElementById("nope-des");
            var y = document.getElementById("text-area");
            var z = document.getElementById("yes-des");
            if (x.classList.contains('hidden')) {
                x.classList.remove('hidden');
                x.classList.add('flex');
            } else {
                x.classList.remove('flex');
                x.classList.add('hidden');
                y.classList.remove('flex');
                y.classList.add('hidden');
                z.classList.remove('hidden');
                z.classList.add('flex');
            }
        }

        window.addEventListener('keydown', function(e) {
            if (e.keyIdentifier == 'U+000A' || e.keyIdentifier == 'Enter' || e.keyCode == 13) {
                if (e.target.nodeName == 'INPUT' && e.target.type == 'text') {
                    e.preventDefault();
                    return false;
                }
            }
        }, true);

        var numberInputs = document.querySelectorAll('input[type="number"]');
        for (var i = 0; i < numberInputs.length; i++) {
            numberInputs[i].addEventListener("wheel", function(event) {
                event.preventDefault();
            });
        }

        let categoryId = "";
        let subCategoryId = "";
        let pozicijaId = "";

        function actionSwall(url, name, id) {
            Swal.fire({
                title: "{{ __('app.create-ponuda.swal-are-you-sure-delete') }} " + name + "?",
                icon: 'question',
                html: '<form method="POST" id="delElement" action="' + url + '">' +
                    '@csrf' +
                    '@method('delete')' +
                    '<input name="id" hidden value="' + id + '">' +
                    '<button type="submit" class="add-new-btn-swal2 w-full mx-1 mt-5">{{ __('app.create-ponuda.izbrisi') }}</button>' +
                    '</form>',
                showCancelButton: false,
                showConfirmButton: false,
                showCloseButton: true,
            })
        }

        function UpdateSwall(getData) {
            var {
                realId,
                tempDesc,
                tempTitle,
                quantity,
                unit_price,
                radioBtn
            } = getData();
            var radioHtml = '';
            if (radioBtn == 1) {
                radioHtml += '<div class="flex justify-start flex-col">' +
                    '<input type="radio" id="new_material" name="new_radioButton" value="1" checked>' +
                    '<label for="new_material" class="font-bold text-main-color">{{ __('app.create-ponuda.price-with-material') }}</label>' +
                    '<input type="radio" id="new_service" name="new_radioButton" value="2">' +
                    '<label class="mt-2 font-bold text-main-color" for="new_service">{{ __('app.create-ponuda.price-without-material') }}</label>' +
                    '</div>';
            } else if (radioBtn == 2) {
                radioHtml += '<div class="flex justify-start flex-col">' +
                    '<input type="radio" id="new_material" name="new_radioButton" value="1">' +
                    '<label for="new_material" class="font-bold text-main-color">{{ __('app.create-ponuda.price-with-material') }}</label>' +
                    '<input type="radio" id="new_service" name="new_radioButton" value="2" checked>' +
                    '<label class="mt-2 font-bold text-main-color" for="new_service">{{ __('app.create-ponuda.price-without-material') }}</label>' +
                    '</div>';
            }
            Swal.fire({
                title: '{{ __('app.create-ponuda.swal-change-pozicija') }}',
                icon: 'question',
                html: '<form method="POST" id="updateDescription" action="{{ route('worker.store.new.update.desc') }}">' +
                    '@csrf' +
                    '@method('put')' +
                    '<span class="font-bold text-main-color">{{ __('app.create-ponuda.swal-pozicija-name') }} :</span>' +
                    '<input name="real_id" hidden value="' + realId + '">' +
                    '<textarea class="mt-3 mb-3 swal-input" rows="3" cols="50" type="text" name="new_title" id="updateTitle">' +
                    tempTitle + '</textarea>' +
                    '<span class="font-bold text-main-color">{{ __('app.create-ponuda.swal-pozicija-des') }} :</span>' +
                    '<textarea class="mt-3 mb-3 swal-input" rows="3" cols="50" type="text" name="new_description" id="updateData">' +
                    tempDesc + '</textarea>' +
                    '<br><p class="mb-3 font-bold text-main-color">{{ __('app.create-ponuda.price-with-material-title') }}:</p>' +
                    radioHtml +
                    '<br><label class="mt-3 mb-2 font-bold text-main-color" for="new_quantity">{{ __('app.create-ponuda.table-kolicina') }}:</label>' +
                    '<input type="number" name="new_quantity" class="swal-input mt-3 mb-2" id="new_quantity" value="' +
                    quantity + '">' +
                    '<label class="mt-3 mb-2 font-bold text-main-color" for="new_unit_price">{{ __('app.create-ponuda.price') }}:</label>' +
                    '<input type="number" name="new_unit_price" class="swal-input mt-3 mb-2" id="new_unit_price" value="' +
                    unit_price + '">' +
                    '<button type="submit" class="add-new-btn-swal2 w-full mx-1 mt-5">{{ __('app.create-ponuda.table-izmeni') }}</button>' +
                    '</form>',
                showCancelButton: false,
                showConfirmButton: false,
                showCloseButton: true,
                confirmButtonColor: '#22ff00',
                cancelButtonColor: '#d33',
            })
        }

        function NameSwall(tempPonudaName) {
            let opis = document.getElementById("opis").value;
            Swal.fire({
                title: '{{ __('app.create-ponuda.swal-save-ponuda') }}',
                icon: 'question',
                html: '<form method="POST" id="formDone" action="{{ route('worker.store.new.ponuda.done') }}">' +
                    '@csrf' +
                    '@if (isset($swap[0]))' +
                    '<input type="hidden" name="edit" value="1"/>' +
                    '@else' +
                    '<input type="hidden" name="edit" value="0"/>' +
                    '@endif' +
                    '<label for="ponuda_name" class="font-bold text-main-color">{{ __('app.create-ponuda.swal-ponuda-name') }}:</label>' +
                    '<input class="mt-3 swal-input mb-3" type="text" name="ponuda_name" value="' + tempPonudaName +
                    '"/>' +
                    '<label for="opis" class="mt-3 hidden">{{ __('app.create-ponuda.swal-ponuda-napomena') }}:</label>' +
                    '<textarea class="mt-3 swal-input hidden" rows="4" cols="50" type="text" name="opis">' + opis +
                    '</textarea>' +
                    '<button type="submit" class="add-new-btn-swal2 w-full my-3">{{ __('app.create-ponuda.finish-ponuda-btn') }}</button>' +
                    '</form>',
                showCancelButton: false,
                showConfirmButton: false,
                showCloseButton: true,
                confirmButtonColor: '#22ff00',
                cancelButtonColor: '#d33',
            })
        }

        function OpisSwall(tempPonudaName) {
            let opis = document.getElementById("opis").value;
            Swal.fire({
                title: '{{ __('app.create-ponuda.swal-save-ponuda') }}',
                icon: 'question',
                html: '<form method="POST" id="formDone" action="{{ route('worker.store.new.ponuda.done') }}">' +
                    '@csrf' +
                    '@if (isset($swap[0]))' +
                    '<input type="hidden" name="edit" value="1"/>' +
                    '@else' +
                    '<input type="hidden" name="edit" value="0"/>' +
                    '@endif' +
                    '<label for="ponuda_name" class="font-bold text-main-color">{{ __('app.create-ponuda.swal-ponuda-name') }}:</label>' +
                    '<input class="mt-3 mb-3 swal-input" type="text" name="ponuda_name" value="' + tempPonudaName +
                    '"/>' +
                    '<label for="opis" class="mt-3 hidden">{{ __('app.create-ponuda.swal-ponuda-napomena') }}:</label>' +
                    '<textarea class="mt-3 swal-input hidden" rows="4" cols="50" type="text" name="opis">' + opis +
                    '</textarea>' +
                    '<label for="note" class="mt-3 font-bold text-main-color">{{ __('app.create-ponuda.swal-ponuda-napomena') }}:</label>' +
                    '<textarea class="mt-3 swal-input mb-3" rows="4" cols="50" type="text" name="note">' +
                    '{{ $finished_note }}' +
                    '</textarea>' +
                    '<button type="submit" class="add-new-btn-swal2 w-full my-3">{{ __('app.create-ponuda.finish-ponuda-btn') }}</button>' +
                    '</form>',
                showCancelButton: false,
                showConfirmButton: false,
                showCloseButton: true,
                confirmButtonColor: '#22ff00',
                cancelButtonColor: '#d33',
            })
        }

        function EndPonuda(tempPonudaName) {
            Swal.fire({
                title: '{{ __('app.create-ponuda.swal-add-opis') }}' + '?',
                icon: 'question',
                showCancelButton: true,
                showConfirmButton: true,
                showCloseButton: true,
                confirmButtonText: '{{ __('app.create-ponuda.swal-yes') }}',
                cancelButtonText: '{{ __('app.create-ponuda.swal-no') }}',
            }).then((result) => {
                if (result.isConfirmed) {
                    OpisSwall(tempPonudaName);
                }
                if (result.dismiss == 'cancel') {
                    NameSwall(tempPonudaName);
                }
            })
        }

        function clearUpdateData() {
            document.getElementById("updateData").value = '';
        }

        function clearUpdateTitle() {
            document.getElementById("updateTitle").value = '';
        }
    </script>
    </x-app-work-layout>
