<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ $ponuda_name }}</title>

    <style>
        @page {
            margin: 180px 25px !important;
        }

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

        .border-bold {
            border: 2px solid black !important;
        }

        .text-bold {
            font-weight: 600;
        }

        .logo-side {
            width: 45%;
            float: left;
        }

        .left-side {
            width: 45%;
            float: left;
        }

        .left-side p {
            margin: 3px;
        }

        .right-side {
            width: 45%;
            float: right;
        }

        .right-side p {
            text-align: right;
            margin: 3px;
        }

        .header-style {
            display: block;
            margin-bottom: 100px;
        }

        .name-company {
            width: 45%;
            margin-top: auto;
            float: right;
            padding: 15px;
            border-left: 3px solid rgb(192, 192, 192);
            border-right: 3px solid rgb(192, 192, 192);
            border-radius: 20px;
        }

        .line {
            width: 100%;
            margin-top: 15px;
            border-top: 2px solid rgb(0, 0, 0);
        }

        header {
            position: fixed;
            top: -140px;
            left: 0px;
            right: 0px;
            height: 100px;
            margin-left: 20px;
            margin-right: 20px;
        }

        footer {
            position: fixed;
            bottom: -140px;
            left: 0px;
            right: 0px;
            height: 100px;
            margin-left: 20px;
            margin-right: 20px;
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

        .table-div table {
            page-break-before: always;
        }

        .table-div table:first-child {
            page-break-before: avoid !important;
        }

        .page-break {
            page-break-after: always;
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

</head>

<body style="padding-left: 20px; padding-right: 20px;">
    @php
        $uniqueName = [];
        $finalPrice = 0;
        $titleBold = 0;
        $j = 0;
        $company_name = $company->company_name ?? null;
        $company_city = $company->city ?? null;
        $company_logo = null;
        if (isset($company->logo)) {
            $company_logo = 'data:image/png;base64,' . base64_encode(file_get_contents(storage_path('app/public/' . $company->logo)));
        }
    @endphp
    @if ($mergedData != null)
        @php
            $finalData = $mergedData->sortBy('id')->groupBy('work_type_id');
            $work_type = '';
        @endphp
        @if ($company !== null)
            <header>
                <div style="margin-bottom: 50px;">
                    <div class="header-style">
                        <div class="logo-side">
                            <img src="{{ $company_logo }}" style="object-fit:contain; width:150px; height:80px;">
                        </div>
                        <div class="name-company">
                            <p>{{ $company_name }}</p>
                            <p>{{ $company_city }}</p>
                        </div>
                    </div>
                    <div class="line"></div>
                </div>
            </header>
        @endif

        <footer>
            <div style="height: 100px">
                <p>{{ __('app.generate-pdf.note-text') }}</p>
                <div class="line" style="margin-bottom: 5px;"></div>
                <div class="header-style">
                    @if ($company !== null)
                        <div class="left-side">
                            <p>{{ $company->country }}</p>
                            <p>{{ $company->zip_code }} {{ $company_city }}</p>
                            <p>{{ $company->address }}</p>
                            <p>{{ __('app.profile.telefon') }}: {{ $company->phone }}</p>
                            <p>{{ __('app.profile.email') }}: {{ $company->email }}</p>
                        </div>
                        <div class="right-side">
                            <p>{{ __('app.profile.pib') }}:{{ $company->pib }}</p>
                            <p>{{ __('app.profile.id-number') }}: {{ $company->maticni_broj }}</p>
                            <p>{{ __('app.profile.bank-account') }}: {{ $company->tekuci_racun }}</p>
                            <p>{{ $company->bank_name }}</p>
                            @php
                                if (app()->getLocale() == 'rs-cyrl') {
                                    \Carbon\Carbon::setLocale('sr_RS');
                                } else {
                                    \Carbon\Carbon::setLocale(app()->getLocale());
                                }
                            @endphp
                            <p>{{ now()->translatedFormat('l jS F Y') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </footer>

        <main>
            <table class="ponuda-table" style="border:none;">
                <tr style="border:none;">
                    <td class="text-center no-wrap" style="border:none; font-size:13px;">
                        {{ $ponuda_name }}
                    </td>
                </tr>
            </table>
            @if (isset($client) && $client !== null)
                @if ($type == 1)
                    <p>{{ $client->first_name }} {{ $client->last_name }}</p>
                    <p>{{ $client->city }}, {{ $client->address }}, {{ $client->zip_code }}</p>
                    <p>{{ __('app.profile.telefon') }}: {{ $client->phone }}</p>
                    <p>{{ __('app.profile.email') }}: {{ $client->email }}</p>
                @elseif($type == 2)
                    <p>{{ $client->company_name }}</p>
                    <p>{{ $client->city }}, {{ $client->address }}, {{ $client->zip_code }}</p>
                    <p>{{ __('app.profile.telefon') }}: {{ $client->phone }}</p>
                    <p>{{ __('app.profile.email') }}: {{ $client->email }}</p>
                    <p>{{ __('app.profile.pib') }}: {{ $client->pib }}</p>
                @endif
            @endif
            @if (isset($new) && $new !== null)
                @if (request()->type == 1)
                    <p>{{ request()->f_name }} {{ request()->l_name }}</p>
                    <p>{{ request()->city }}, {{ request()->adresa }}, {{ request()->zip }}</p>
                    <p>{{ __('app.profile.telefon') }}: {{ request()->phone }}</p>
                    <p>{{ __('app.profile.email') }}: {{ request()->email }}</p>
                @elseif(request()->type == 2)
                    <p>{{ request()->company_name }}</p>
                    <p>{{ request()->city }}, {{ request()->adresa }}, {{ request()->zip }}</p>
                    <p>{{ __('app.profile.telefon') }}: {{ request()->phone }}</p>
                    <p>{{ __('app.profile.email') }}: {{ request()->email }}</p>
                    <p>{{ __('app.profile.pib') }}: {{ request()->pib }}</p>
                @endif
            @endif
            <div class="table-div">
                @foreach ($finalData as $data)
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
                            <tr class="no-br-after">
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
                                            <td colspan="6"
                                                class="text-right border-bold whitespace-nowrap padding-5"
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
        <table class="ponuda-table mt-5" style="page-break-before: always;">
            <tbody>
                <tr>
                    <td colspan="2" class="text-left border-bold padding-5"
                        style="background-color: rgba(0, 0, 0, 0.05);">
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
        <p style="font-size: 12px;">
            <b>{{ __('app.archive-selected.note') }}:</b>
        </p>
        <br>
        <p style="margin-top: -15px;">
            <pre>{{ $opis }}</pre>
        </p>
    @endif
    </div>
    @endif
    </main>
</body>

</html>
