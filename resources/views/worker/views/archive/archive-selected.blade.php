<x-app-worker-layout>
    <x-slot name="pageTitle">
        {{ __('app.nav.archive') }}
    </x-slot>
    <x-slot name="header">
        {{ __('app.nav.archive') }}
    </x-slot>

    @php
        $finalPrice = 0;
        $titleBold = 0;
        $uniqueName = [];
        if (app()->getLocale() == 'rs-cyrl') {
            \Carbon\Carbon::setLocale('sr_RS');
        } else {
            \Carbon\Carbon::setLocale(app()->getLocale());
        }
    @endphp

    @if ($mergedData != null)
        <div class="flex mt-16 sm:mb-0 mb-10">
            <div class="flex justify-center flex-col w-full items-center sm:gap-5 gap-8">
                <div class="flex w-full sm:gap-5 gap-8 sm:flex-row flex-col">
                    <a href="{{ route('worker.archive.select.contact', ['id' => $ponuda_name->id_ponuda]) }}"
                        class="archive-pdf-btn text-lg">
                        <i class="ri-download-2-line"></i>{{ __('app.archive-selected.generate-pdf') }}</a>
                    <a target="_blank" href="{{ route('worker.archive.view.pdf', ['id' => $ponuda_name->id_ponuda]) }}"
                        class="archive-pdf-btn text-lg">
                        <i class="ri-eye-line"></i>{{ __('app.archive-selected.check-pdf') }}</a>
                </div>
                <div class="flex w-full sm:gap-5 gap-8 sm:flex-row flex-col">
                    <a href="{{ route('worker.archive.edit', ['ponuda_id' => $ponuda_name->id_ponuda]) }}"
                        class="archive-pdf-btn text-lg">
                        <i class="ri-edit-line"></i>{{ __('app.archive-selected.modify-offer') }}</a>
                    <a href="{{ route('worker.archive.download.empty.contract') }}" class="archive-pdf-btn text-lg">
                        <i class="ri-download-2-line"></i>{{ __('app.profile.download-empty-contract') }}
                    </a>
                </div>
            </div>
        </div>
        <br>
        <p class="sm:mt-10 mt-0 sm:mb-0 mb-2 text-lg">
            {{ __('app.archive.created') }}: <b>{{ $ponuda_name->created_at->translatedFormat('l jS F Y H:i') }}</b>
        </p>

        @if (isset($ponuda_name->updated_at))
            <p class="sm:mt-10 mt-0 sm:mb-0 mb-2 text-lg">
                {{ __('app.archive.updated') }}: {{ $ponuda_name->updated_at->translatedFormat('l jS F Y H:i') }}
            </p>
        @endif

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

    @if (isset($ponuda_name->opis) && $ponuda_name->opis != '')
        <div>
            <p class="mt-10 font-bold">
                {{ __('app.archive-selected.note') }}:
            </p>
            <br>
            <p>
                <pre>{{ $ponuda_name->opis }}</pre>
            </p>
        </div>
    @endif

    @endif

    <script>
        function actionSwall(url, name, id, realId) {
            Swal.fire({
                title: '{{ __('app.create-ponuda.swal-are-you-sure-delete') }} "' + name + '"?',
                icon: 'question',
                html: '<form method="POST" id="delete_item" action="' + url + '">' +
                    '@csrf' +
                    '@method('delete')' +
                    '<input name="id" hidden value="' + id + '">' +
                    '<input name="real_id" hidden value="{{ $ponuda_id }}">' +
                    '<button type="submit" class="add-new-btn mx-1 mt-5">{{ __('app.basic.delete') }}</button>' +
                    '</form>',
                showCancelButton: false,
                showConfirmButton: false,
                showCloseButton: true,
            })
        }
    </script>

</x-app-worker-layout>
