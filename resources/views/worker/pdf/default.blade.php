<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ $ponuda_name }}</title>
</head>
<style type="text/css">
    * {
        font-family: "DejaVu Sans Mono", monospace;
        font-size: 9px;
    }

    .ponuda-table td,
    .ponuda-table th {
        border: 1px solid black;
    }

    .w-100 {
        width: 100%;
    }

    .ponuda-table {
        margin-bottom: 30px;
        width: 100%;
        border-collapse: collapse;
    }

    .border-left {
        border-right: 1px solid black;
    }

    .text-left {
        text-align: left !important;
    }

    .text-center {
        text-align: center;
    }

    .text-right {
        text-align: right !important;
    }

    .no-wrap {
        white-space: nowrap;
    }

    .padding-5 {
        padding-left: 5px;
        padding-right: 5px;
    }

    .table-padding {
        padding: 5px 10px;
    }

    .table-padding-small {
        padding: 5px;
    }

    .table-padding-small-x {
        padding-left: 8px;
        padding-right: 8px;
    }

    .border-bold {
        border: 2px solid black !important;
    }

    .text-bold {
        font-weight: 600;
    }

    .no-br-before {
        page-break-before: avoid;
    }

    .no-br-after {
        page-break-after: avoid;
    }

    .h-10 {
        height: 5px;
    }
</style>

<body style="padding-left: 20px; padding-right: 20px;">
    @php
        $finalPrice = 0;
        $titleBold = 0;
        $uniqueName = [];
    @endphp
    @if ($mergedData != null)
        @php
            $finalData = $mergedData->sortBy('id')->groupBy('work_type_id');
            $work_type = '';
        @endphp
        <table class="ponuda-table">
            <tr>
                <td class="text-center no-wrap">
                    {{ $ponuda_name }}
                </td>
            </tr>
        </table>
        @foreach ($finalData as $data)
        <div>
            <table class="ponuda-table">
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
                        <td colspan="6" class="text-left border-bold padding-5"
                            style="background-color: rgba(0, 0, 0, 0.15);">
                            <b>{{ $name_work_type }}</b>
                        </td>
                    </tr>
                    <tr class="no-br-before">
                        <td colspan="6" class="h-10" style="border: none !important"></td>
                    </tr>  
                </thead>
                <tbody>
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
                                <tr class="no-br-after">
                                    <td colspan="6" class="text-left border-bold padding-5"
                                        style="background-color: rgba(0, 0, 0, 0.05);">
                                        <b>{{ $name_category }}</b>
                                        @php
                                            $uniqueName[] = $name_category;
                                        @endphp
                                    </td>
                                </tr>
                                <tr class="no-br-after">
                                    <th scope="col" class="table-padding-small">
                                        {{ __('app.create-ponuda.table-r-br') }}
                                    </th>
                                    <th scope="col" class="table-padding-small">
                                        {{ __('app.create-ponuda.table-naziv') }}
                                    </th>
                                    <th scope="col" class="table-padding-small">
                                        {{ __('app.create-ponuda.table-j-m') }}
                                    </th>
                                    <th scope="col" class="table-padding-small">
                                        {{ __('app.create-ponuda.table-kolicina') }}
                                    </th>
                                    <th scope="col" class="table-padding-small">
                                        {{ __('app.create-ponuda.table-jed-cena') }}
                                    </th>
                                    <th scope="col" class="table-padding-small">
                                        {{ __('app.create-ponuda.table-ukupno') }}
                                    </th>
                                </tr>
        @endif
        @php
            $overall_price = $item->quantity * $item->unit_price;
            $subPrice += $overall_price;
        @endphp
            <tr>
                <td class="text-center">{{ $i++ }}</td>
                <td class="text-left ponuda-table-des padding-5"><b>
                        {{ $title }}
                    </b><br>
                    {{ $desc_now }}
                    <br>{{ $item->name_service }}
                </td>
                <td class="text-center padding-5">{{ $item->unit_name }}</td>
                <td class="text-center padding-5">{{ $item->quantity }}</td>
                <td class="text-center padding-5">
                    {{ number_format($item->unit_price, 2) }}&nbsp;{{ __('app.create-ponuda.table-rsd') }}
                </td>
                <td class="whitespace-nowrap padding-5 border-left text-center">
                    {{ number_format($overall_price, 2) }}&nbsp;{{ __('app.create-ponuda.table-rsd') }}
                </td>
            </tr>

            @if ($loop->last)
                <tr class="no-br-before">
                    <td colspan="6" class="text-right border-bold whitespace-nowrap padding-5"
                        style="background-color: rgba(0, 0, 0, 0.05);">
                        <b>
                            {{ __('app.create-ponuda.table-svega') }}&nbsp;
                            <span class="lowercase">{{ $name_category }} :</span>
                        </b>&nbsp;{{ number_format($subPrice, 2) }}&nbsp;
                        {{ __('app.create-ponuda.table-rsd') }}
                    </td>
                </tr>
                <tr class="no-br-before">
                    <td colspan="6" class="h-10" style="border: none !important"></td>
                </tr>  
            @endif
    @endforeach
    @if ($loop->last)
        <tr class="no-br-before">
            <td colspan="6" class="text-right border-bold whitespace-nowrap padding-5"
                style="background-color: rgba(0, 0, 0, 0.15);">
                <b>
                    {{ __('app.create-ponuda.table-svega') }}&nbsp;
                    <span class="lowercase">{{ $work_type }} :</span>
                </b>&nbsp;{{ number_format($sumWorkType, 2) }}&nbsp;
                {{ __('app.create-ponuda.table-rsd') }}
            </td>
        </tr>
    @endif
    @endforeach
    </tbody>
    </table>
    </div>
    @endforeach
    <div>
        <table class="ponuda-table mt-5">
            <tbody>
                <tr>
                    <td colspan="2" class="text-left border-bold padding-5" style="background-color: rgba(0, 0, 0, 0.05);">
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
                                <td class="text-left w-full padding-5">
                                    {{ $work_type_rekapitulacija }}&nbsp;
                                </td>
                                <td class="padding-5 text-right whitespace-nowrap">
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
                <td class="text-right padding-5">
                    <b>{{ __('app.create-ponuda.table-ukupno') }}:
                        {{ number_format($finalPrice, 2) }}&nbsp;{{ __('app.create-ponuda.table-rsd') }}</b>
                </td>
            </tr>
            <tr>
                <td class="text-right padding-5">
                    @php
                        $pdv = $finalPrice * 0.2;
                    @endphp
                    {{ __('app.create-ponuda.table-pdv') }}: {{ number_format($pdv, 2) }}
                    {{ __('app.create-ponuda.table-rsd') }}
                </td>
            </tr>
            <tr>
                <td class="text-right padding-5">
                    @php
                        $final = $pdv + $finalPrice;
                    @endphp
                    <b>{{ __('app.create-ponuda.table-ukupno-sa-pdv') }}: {{ number_format($final, 2) }}
                        {{ __('app.create-ponuda.table-rsd') }}</b>
                </td>
            </tr>
        </table>
    </div>

    @if (isset($opis))
        <span>
            <b>
                {{ __('app.archive-selected.note') }} :
            </b>
        </span>
        <br>
        <p style="margin-top: -15px;">
            <pre>{{ $opis }}</pre>
        </p>
    @endif

    <div style="float:right;">

        @php
            if (app()->getLocale() == 'rs-cyrl') {
                \Carbon\Carbon::setLocale('sr_RS');
            } else {
                \Carbon\Carbon::setLocale(app()->getLocale());
            }
        @endphp

        <p>{{ now()->translatedFormat('l jS F Y') }}</p>
    </div>
    </div>
    @endif
</body>

</html>
