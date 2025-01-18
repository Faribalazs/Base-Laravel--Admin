<x-app-worker-layout>
    <x-slot name="pageTitle">
        {{ __('Ugovor') }}
    </x-slot>
    <x-slot name="header">
        {{ __('Ugovor za pravna lica') }}
    </x-slot>
    <form method="POST" action="{{ route('worker.archive.download.contract') }}">
        @csrf
        @method('post')
        <input type="hidden" name="mailTo" value="{{ $mailTo }}">
        <div class="con">
            <div class="mt-20 border border-grey rounded lg:p-14 sm:p-10 p-4 main-div">
                <div class="px-10 flex flex-col">
                    <div class="text-lg text-center mb-14">
                        <b>
                            {{ __('UGOVOR br.') }} <input type="text" class="w-20" style="border-radius: 0px !important;" name="br">
                            <br>{{ __('O IZVOĐENJU GRAĐEVINSKO - ZANATSKIH RADOVA') }}
                        </b>
                    </div>
                    <div class="text-lg lg:text-justify">
                        <p class="mb-10">
                            {{ __('Zaključen između') }}
                            <input type="text" style="border-radius: 0px !important;" class="w-60" name="field1"
                                value="{{ $foundClient->company_name }}"> {{ __('iz') }} 
                            <input type="text" style="border-radius: 0px !important;" name="field2"
                                value="{{ $foundClient->city }}">,
                                {{ __('adresa') }}:<input type="text" style="border-radius: 0px !important;" name="field3"
                                value="{{ $foundClient->address }}">,
                            {{ __('s jedne strane kao naručioca (u daljem tekstu: Naručilac) i') }}
                        </p>
                        <p>
                            <input type="text" style="border-radius: 0px !important;" name="field4"
                                value="{{ $company_data->company_name }}">
                             {{ __('iz') }} 
                            <input type="text" style="border-radius: 0px !important;" name="field5"
                                value="{{ $company_data->city }}">,
                            {{ __('adresa') }}:<input type="text" style="border-radius: 0px !important;" name="field6"
                                value="{{ $company_data->address }}">,
                            {{ __('PIB') }}:<input type="text" style="border-radius: 0px !important;" class="w-52"
                                name="field7" value="{{ $company_data->pib }}">
                            {{ __('s druge strane, koje zastupa direktor') }} <input type="text"
                                style="border-radius: 0px !important;" name="field8">
                            {{ __('iz') }} <input type="text" style="border-radius: 0px !important;" name="field9">, {{ __('kao izvođača (u daljem tekstu: Izvođač)') }}.
                        </p>
                        <p class="my-10">
                            {{ __('Ugovorne strane su se sporazumele o sledećem') }}:
                        </p>
                        <p class="text-center mb-10">
                            {{ __('Član') }} 1.
                        </p>
                        <p class="mb-10">
                            {{ __('Izvođač se obavezuje da za račun Naručioca izvede građevinsko - zanatske radove na objektu u') }}
                            <input type="text" style="border-radius: 0px !important;" class="w-56" name="field10">
                            {{ __('ul.') }} <input type="text" style="border-radius: 0px !important;" name="field11">
                            {{ __('br.') }}<input type="text" style="border-radius: 0px !important;" name="field12"
                                class="w-32">
                            {{ __('u svemu prema usvojenoj ponudi Izvođača br.') }}<input type="text" class="w-48"
                                style="border-radius: 0px !important;" name="field13">
                            {{ __('od') }} <input type="date" id="dateInput" value="{{ date('Y-m-d') }}" onchange="myDateFormat()" min="2013-01-01" max="2033-12-31" class="w-44" style="border-radius: 0px !important;" name="field14"><input type="text" id="showDate" class="w-44" style="border-radius: 0px !important; display:none" onclick="showDatePicker()" ></span>
                            {{ __('koja čini sastavni deo ovog Ugovora.') }}
                        </p>
                        <p class="text-center mb-10">
                            {{ __('Član') }} 2.
                        </p>
                        <p class="mb-5">
                            {{ __('Izvođač se obavezuje da:') }}
                        </p>
                        <p class="mb-10">
                            - {{ __('sve radove iz člana 1. ovog ugovora izvede u skladu sa važećim tehničkim normativima, standardima i propisima;') }}
                            <br>
                            - {{ __('upotrebljava materijal i opremu koji u svemu odgovaraju važećim normativima i standardima;') }}
                            <br>
                            - {{ __('će se u toku izvođenja radova pridržavati svih važećih normi iz oblasti bezbednosti i zdravlja na radu.') }}
                        </p>
                        <p class="text-center mb-10">
                            {{ __('Član') }} 3.
                        </p>
                        <p class="mb-10">
                            {{ __('Naručilac se obavezuje da na ime cene za sve radove na objektu, iz člana 1. ovog ugovora, plati izvođaču ukupan iznos od') }} 
                            <input type="text" style="border-radius: 0px !important;" class="w-40" name="field15" 
                                value="{{ number_format($sum,2) }}"> {{ __('dinara (slovima:') }} <input type="text" style="border-radius: 0px !important;" name="field16"
                                value="{{ $sum_in_words }}" > {{ __('dinara), sa uračunatim PDV-om.') }}
                        </p>
                        <p class="text-center mb-10">
                            {{ __('Član') }} 4.
                        </p>
                        <p class="mb-10">
                            {{ __('Ukoliko se ukaže potreba za izvođenjem dodatnih ili nepredviđenih radova, Izvođač će pristupiti njihovom izvođenju nakon ispostavljanja Ponude za ove radove koju će Investitor pisanim putem prihvatiti.') }}<br>
                            {{ __('U ovom slučaju, ugovorena cena radova iz člana 3 ovog ugovora će se uvećati za iznos dodatnih ili nepredviđenih radova.') }}
                        </p>
                        <p class="text-center mb-10">
                            {{ __('Član') }} 5.
                        </p>
                        <p class="mb-10">
                            {{ __('Naručilac se obavezuje da će na ime avansa Izvođaču uplatiti iznos od') }} 
                            <input type="text" style="border-radius: 0px !important;" class="w-40" name="field17"> 
                            {{ __('dinara, u skladu sa uslovima iz usvojene ponude Izvođača.') }}
                        </p>
                        <p class="text-center mb-10">
                            {{ __('Član') }} 6.
                        </p>
                        <p class="mb-10">
                            {{ __('Izvođač se obavezuje da će radove započeti u roku od') }} 
                            <input type="text" style="border-radius: 0px !important;" class="w-20" name="field18"> 
                            {{ __('dana od dana uplate avansa, u skladu sa uslovima iz usvojene ponude Izvođača.') }}
                        </p>
                        <p class="text-center mb-10">
                            {{ __('Član') }} 7.
                        </p>
                        <p class="mb-10">
                            {{ __('Izvođač s obavezuje da sve radove na objektu iz člana 1. ovog ugovora izvede u roku od') }} 
                            <input type="text" style="border-radius: 0px !important;" class="w-20"
                                name="field19"> 
                            {{ __('radnih dana, u skladu sa uslovima iz usvojene ponude Izvođača.') }}
                        </p>
                        <p class="text-center mb-10">
                            {{ __('Član') }} 8.
                        </p>
                        <p class="mb-10">
                            {{ __('Izvođač Naručiocu na izvedene radove daje garanciju u trajanju od dve (dve) godine od dana primopredaje radova.') }}
                        </p>
                        <p class="text-center mb-10">
                            {{ __('Član') }} 9.
                        </p>
                        <p class="mb-10">
                            {{ __('Na sve što nije precizirano ovim ugovorom, primenjivaće se odredbe Zakona o obligacionim odnosima.') }}
                        </p>
                        <p class="text-center mb-10">
                            {{ __('Član') }} 10.
                        </p>
                        <p class="mb-10">
                            {{ __('Sve eventualne sporove ugovorne strane će rešavati mirnim putem. Ukoliko do rešenja spora nije moguće doći na ovaj način, ugovara se nadležnost suda u') }} 
                            <input type="text" style="border-radius: 0px !important;" class="w-52"
                                name="field20">.
                        </p>
                        <p class="text-center mb-10">
                            {{ __('Član') }} 11.
                        </p>
                        <p class="mb-10">
                            {{ __('Ovaj ugovor sačinjen je u') }} 
                            <input type="text" style="border-radius: 0px !important;" class="w-20"
                                name="field21"> 
                            {{ __('istovetna primerka, od kojih se') }}
                            <input type="text" style="border-radius: 0px !important;" class="w-20"
                                name="field22"> 
                            {{ __('primerka nalaze kod Naručioca, a') }} 
                            <input type="text" style="border-radius: 0px !important;" class="w-20"
                                name="field23"> 
                            {{ __('primerka kod Izvođača.') }}
                            {{ __('U') }} <input type="text" style="border-radius: 0px !important;" class="w-52"
                                name="field24"> ,
                            {{ __('dana') }} <input type="text" style="border-radius: 0px !important;" class="w-32"
                                name="field25"> {{ __('godine') }}.
                        </p>
                    </div>
                    <div class="flex justify-between w-100 mt-20">
                        <div class="w-min flex flex-col gap-12 text-center">
                            {{ __('IZVOĐAČ') }}
                            <div class="w-72 border-b"></div>
                        </div>
                        <div class="w-min flex flex-col gap-12 text-center">
                            {{ __('NARUČILAC') }}
                            <div class="w-72 border-b"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex justify-center mt-20">
            <button onClick="showBack()" type="submit"
                class="sm:w-1/2 w-full mx-auto text-xl font-bold finish-btn mt-5"
                name="skini" value="skini">
                {{ __('Skini ispunjen Ugovor') }}
            </button>

            <button onClick="showBack()" type="submit"
                class="sm:w-1/2 w-full mx-auto text-xl font-bold finish-btn mt-5"
                name="posalji" value="posalji">
                {{ __('Pošalji ispunjen Ugovor') }}
            </button>
        </div>
    </form>
    <script>
        function showBack() {
            btn = document.querySelector('.btn');
            btn.style.display = 'flex';
        }

        function myDateFormat() {
            var dateControl = document.getElementById('dateInput');
            const [year, month, day] = dateControl.value.split('-');
            const result = [day, month, year].join('/');
            document.getElementById("showDate").value = result;
            document.getElementById("showDate").style.display = 'inline-block';
            document.getElementById("dateInput").style.display = 'none';
        }

        function showDatePicker() {
            var dateInput = document.getElementById('dateInput');
            dateInput.style.display = 'inline-block';
            document.getElementById("showDate").style.display = 'none';

            dateInput.focus();
        }
        function resizable(el, factor) {
            var int = Number(factor) || 11;
            function resize() {
                el.style.width = ((el.value.length + 3) * int) + 'px';
            }
            var e = 'keyup,keypress,focus,blur,change'.split(',');
            for (var i in e) {
                el.addEventListener(e[i], resize, false);
            }
            resize();
        }

        var inputs = document.querySelectorAll('input:not(#showDate,#dateInput)');
        for (var i = 0; i < inputs.length; i++) {
            resizable(inputs[i], 11);
        }
    </script>
    <style>
        input {
            border: none !important;
            border-bottom: 1px solid black !important;
            text-align: center;
            padding-bottom: 3px !important;
            font-size: 18px !important;
            background-color: #fafafa !important;
        }

        p {
            line-height: 3;
        }

        .main-div {
            min-width: 960px;
        }

        .con {
            width: 100%;
            overflow: scroll;
        }
    </style>
</x-app-worker-layout>
