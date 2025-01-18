<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ __('Ugovor Ponuda Majstora') }}</title>
    <style type="text/css">
        * {
          font-family: "DejaVu Sans Mono", monospace;
          font-size: 9px;
        }
    </style>
</head>
<body style="padding-left: 20px; padding-right: 20px;">
    <div style="text-align: center">
        <b>
            {{ __('UGOVOR br.') }} <u>&nbsp;{{ $ugovorBr }}&nbsp;</u>
            <br>
            {{ __('O IZVOĐENJU GRAĐEVINSKO - ZANATSKIH RADOVA') }}
        </b>
    </div>
    <br>
    {{ __('Zaključen između') }} <u>&nbsp;{{ $fields[0] }}&nbsp;</u> {{ __('iz') }} <u>&nbsp;{{ $fields[1] }}&nbsp;</u>, {{ __('adresa') }}:<u>&nbsp;{{ $fields[2] }}&nbsp;</u>, {{ __('s jedne strane kao naručioca (u daljem tekstu: Naručilac) i') }}
    <br><br>
    <u>&nbsp;{{ $fields[3] }}&nbsp;</u> {{ __('iz') }} <u>&nbsp;{{ $fields[4] }}&nbsp;</u>, {{ __('adresa') }}:<u>&nbsp;{{ $fields[5] }}&nbsp;</u>, {{ __('PIB') }}:<u>&nbsp;{{ $fields[6] }}&nbsp;</u> {{ __('s druge strane, koje zastupa direktor') }} <u>&nbsp;{{ $fields[7] }}&nbsp;</u> {{ __('iz') }} <u>&nbsp;{{ $fields[8] }}&nbsp;</u> , {{ __('kao izvođača (u daljem tekstu: Izvođač)') }}.
    <br><br>
    {{ __('Ugovorne strane su se sporazumele o sledećem') }}:
    <br><br>
    {{ __('Član') }} 1.
    <br><br>
    {{ __('Izvođač se obavezuje da za račun Naručioca izvede građevinsko - zanatske radove na objektu u') }} <u>&nbsp;{{ $fields[9] }}&nbsp;</u> {{ __('ul.') }} <u>&nbsp;{{ $fields[10] }}&nbsp;</u> {{ __('br.') }}<u>&nbsp;{{ $fields[11] }}&nbsp;</u> {{ __('u svemu prema usvojenoj ponudi Izvođača br.') }}<u>&nbsp;{{ $fields[12] }}&nbsp;</u> {{ __('od') }} <u>&nbsp;{{ $fields[13] }}&nbsp;</u> {{ __('koja čini sastavni deo ovog Ugovora.') }}
    <br><br>
    {{ __('Član') }} 2.
    <br><br>
    {{ __('Izvođač se obavezuje da:') }}
    <br><br>
    - {{ __('sve radove iz člana 1. ovog ugovora izvede u skladu sa važećim tehničkim normativima, standardima i propisima;') }}
    <br>
    - {{ __('upotrebljava materijal i opremu koji u svemu odgovaraju važećim normativima i standardima;') }}
    <br>
    - {{ __('će se u toku izvođenja radova pridržavati svih važećih normi iz oblasti bezbednosti i zdravlja na radu.') }}
    <br><br>
    {{ __('Član') }} 3.
    <br><br>
    {{ __('Naručilac se obavezuje da na ime cene za sve radove na objektu, iz člana 1. ovog ugovora, plati izvođaču ukupan iznos od') }} <u>&nbsp;{{ $fields[14] }}&nbsp;</u> {{ __('dinara (slovima:') }} <u>&nbsp;{{ $fields[15] }}&nbsp;</u> {{ __('dinara), sa uračunatim PDV-om.') }}
    <br><br>
    {{ __('Član') }} 4.
    <br><br>
    {{ __('Ukoliko se ukaže potreba za izvođenjem dodatnih ili nepredviđenih radova, Izvođač će pristupiti njihovom izvođenju nakon ispostavljanja Ponude za ove radove koju će Investitor pisanim putem prihvatiti.') }}<br>
    {{ __('U ovom slučaju, ugovorena cena radova iz člana 3 ovog ugovora će se uvećati za iznos dodatnih ili nepredviđenih radova.') }}
    <br><br>
    {{ __('Član') }} 5.
    <br><br>
    {{ __('Naručilac se obavezuje da će na ime avansa Izvođaču uplatiti iznos od') }} <u>&nbsp;{{ $fields[16] }}&nbsp;</u> {{ __('dinara, u skladu sa uslovima iz usvojene ponude Izvođača.') }} 
    <br><br>
    {{ __('Član') }} 6.
    <br><br>
    {{ __('Izvođač se obavezuje da će radove započeti u roku od') }} <u>&nbsp;{{ $fields[17] }}&nbsp;</u> {{ __('dana od dana uplate avansa, u skladu sa uslovima iz usvojene ponude Izvođača.') }}
    <br><br>
    {{ __('Član') }} 7.
    <br><br>
    {{ __('Izvođač s obavezuje da sve radove na objektu iz člana 1. ovog ugovora izvede u roku od') }} <u>&nbsp;{{ $fields[18] }}&nbsp;</u> {{ __('radnih dana, u skladu sa uslovima iz usvojene ponude Izvođača.') }}
    <br><br>
    {{ __('Član') }} 8.
    <br><br>
    {{ __('Izvođač Naručiocu na izvedene radove daje garanciju u trajanju od dve (dve) godine od dana primopredaje radova.') }}
    <br><br>
    {{ __('Član') }} 9.
    <br><br>
    {{ __('Na sve što nije precizirano ovim ugovorom, primenjivaće se odredbe Zakona o obligacionim odnosima.') }}
    <br><br>
    {{ __('Član') }} 10.
    <br><br>
    {{ __('Sve eventualne sporove ugovorne strane će rešavati mirnim putem. Ukoliko do rešenja spora nije moguće doći na ovaj način, ugovara se nadležnost suda u') }} <u>&nbsp;{{ $fields[19] }}&nbsp;</u>.
    <br><br>
    {{ __('Član') }} 11.
    <br><br>
    {{ __('Ovaj ugovor sačinjen je u') }} <u>&nbsp;{{ $fields[20] }}&nbsp;</u> {{ __('istovetna primerka, od kojih se') }} <u>&nbsp;{{ $fields[21] }}&nbsp;</u> {{ __('primerka nalaze kod Naručioca, a') }} <u>&nbsp;{{ $fields[22] }}&nbsp;</u> {{ __('primerka kod Izvođača.') }}
    <br><br>
    {{ __('U') }} <u>&nbsp;{{ $fields[23] }}&nbsp;</u> , {{ __('dana') }} <u>&nbsp;{{ $fields[24] }}&nbsp;</u> {{ __('godine') }}.
    <br><br>
    <div style="float:left">
        <div style="text-align: center">
            {{ __('IZVOĐAČ') }}
            <br><br>
            _____________________
        </div>
     </div>
     
     <div style="float:right">
        <div style="text-align: center">
            {{ __('NARUČILAC') }}
            <br><br>
            _____________________
        </div>
     </div>
</body>

</html>
