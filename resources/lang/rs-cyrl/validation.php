<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'Поље :attribute мора бити прихваћено.',
    'accepted_if' => 'Поље :attribute мора бити прихваћено када је вредност поља :other :value.',
    'active_url' => 'Поље :attribute није валидан УРЛ.',
    'after' => 'Поље :attribute мора да буде датум после :date.',
    'after_or_equal' => 'Поље :attribute мора да буде датум једнак или после :date.',
    'alpha' => 'Поље :attribute може да садржи само слова.',
    'alpha_dash' => 'Поље :attribute може да садржи само слова, бројеве, повлаке и доње црте.',
    'alpha_num' => 'Поље :attribute може да садржи само слова и бројеве.',
    'array' => 'Поље :attribute мора да буде низ.',
    'before' => 'Поље :attribute мора да буде датум пре :date.',
    'before_or_equal' => 'Поље :attribute мора да буде датум једнак или пре :date.',
    'between' => [
        'numeric' => 'Поље :attribute мора да буде између :min и :max.',
        'file' => 'Поље :attribute мора да буде између :min и :max килобајта.',
        'string' => 'Поље :attribute мора да буде између :min и :max карактера.',
        'array' => 'Поље :attribute мора да садржи између :min и :max елемената.',
    ],
    'boolean' => 'Поље :attribute мора да буде тачно или нетачно.',
    'confirmed' => 'Потврда поља :attribute се не поклапа.',
    'current_password' => 'Лозинка је неисправна.',
    'date' => 'Поље :attribute није исправан датум.',
    'date_equals' => 'Поље :attribute мора да буде датум једнак :date.',
    'date_format' => 'Поље :attribute не одговара формату :format.',
    'declined' => 'Поље :attribute мора бити одбијено.',
    'declined_if' => 'Поље :attribute мора бити одбијено када је вредност поља :other :value.',
    'different' => 'Поља :attribute :other морају бити различита.',
    'digits' => 'Поље :attribute мора садржати :digits цифре.',
    'digits_between' => 'Поље :attribute мора да садржи између :min и :max цифри.',
    'dimensions' => 'Поље :attribute садржи недозвољене димензије слике.',
    'distinct' => 'Поље :attribute садржи дуплирану вредност.',
    'email' => 'Поље :attribute мора да буде исправна е-мејл адреса.',
    'ends_with' => 'Поље :attribute мора да се заврши са једном од следећих вредности: :values.',
    'enum' => 'Изабрано поље :attribute је неисправно.',
    'exists' => 'Изабрано поље :attribute је неисправно.',
    'file' => 'Поље :attribute мора да буде фајл.',
    'filled' => 'Поље :attribute мора да садржи вредност.',
    'gt' => [
        'numeric' => 'Поље :attribute мора да буде веће од :value.',
        'file' => 'Поље :attribute mora da bude veće od :value kilobajta.',
        'string' => 'Поље :attribute mora da sadrži više od :value karaktera.',
        'array' => 'Поље :attribute mora da sadrži više od :value elemenata.',
    ],
    'gte' => [
        'numeric' => 'Поље :attribute мора да буде веће или једнако од :value.',
        'file' => 'Поље :attribute mora da bude veće ili jednako od :value kilobajta.',
        'string' => 'Поље :attribute mora da sadrži tačno ili više od :value karaktera.',
        'array' => 'Поље :attribute mora da sadrži :value ili više elemenata.',
    ],
    'image' => 'Поље :attribute мора да буде слика.',
    'in' => 'Izabrano Поље :attribute je neispravno.',
    'in_array' => 'Поље :attribute se ne nalazi u :other.',
    'integer' => 'Поље :attribute мора да буде број.',
    'ip' => 'Поље :attribute mora da bude ispravna IP adresa.',
    'ipv4' => 'Поље :attribute mora da bude ispravna IPv4 adresa.',
    'ipv6' => 'Поље :attribute mora da bude ispravna IPv6 adresa.',
    'json' => 'Поље :attribute mora da bude ispravan JSON format.',
    'lt' => [
        'numeric' => 'Поље :attribute mora da bude manje od :value.',
        'file' => 'Поље :attribute mora da bude manje od :value kilobajta.',
        'string' => 'Поље :attribute mora da sadrži manje od :value karaktera.',
        'array' => 'Поље :attribute mora da sadrži manje od :value elemenata.',
    ],
    'lte' => [
        'numeric' => 'Поље :attribute mora da bude manje ili jednako od :value.',
        'file' => 'Поље :attribute mora da bude manje ili jednako od :value kilobajta.',
        'string' => 'Поље :attribute mora da sadrži tačno ili manje od :value karaktera.',
        'array' => 'Поље :attribute mora da sadrži tačno ili manje od :value elementa.',
    ],
    'mac_address' => 'Поље :attribute mora da bude ispravna MAC adresa.',
    'max' => [
        'numeric' => 'Поље :attribute mora da bude manje od :max.',
        'file' => 'Поље :attribute mora da bude manje od :max kilobajta.',
        'string' => 'Поље :attribute mora da sadrži manje od :max karaktera.',
        'array' => 'Поље :attribute mora da sadrži manje od :max elemenata.',
    ],
    'mimes' => 'Поље :attribute мора да буде фајл типа: :values.',
    'mimetypes' => 'Поље :attribute мора да буде фајл типа: :values.',
    'min' => [
        'numeric' => 'Поље :attribute мора да буде најманје :min.',
        'file' => 'Поље :attribute мора да буде најманје :min kilobajta.',
        'string' => 'Поље :attribute mora da sadrži najmanje :min karaktera.',
        'array' => 'Поље :attribute mora da sadrži najmanje :min elemenata.',
    ],
    'multiple_of' => 'Поље :attribute mora da bude višestruko od :value.',
    'not_in' => 'Izabrano Поље :attribute je neispravno.',
    'not_regex' => 'Format polja :attribute  je neispravan.',
    'numeric' => 'Поље :attribute mora da bude broj.',
    'password' => 'Лозинка је нетачна.',
    'present' => 'Поље :attribute mora da bude prisutno.',
    'prohibited' => 'Поље :attribute je zabranjeno.',
    'prohibited_if' => 'Поље :attribute je zabranjeno kada je vrednost polja :other :value.',
    'prohibited_unless' => 'Поље :attribute je zabranjeno osim ako je vrednost polja :other :values.',
    'prohibits' => 'Поље :attribute zabranjuje polju :other da bude prisutno.',
    'regex' => 'Формат поља :attribute је неисправан.',
    'required' => 'Поље :attribute је обавезно.',
    'required_array_keys' => 'Поље :attribute mora da sadrži unose za: :values.',
    'required_if' => 'Поље :attribute je obavezno kada je vrednost polja :other :value.',
    'required_unless' => 'Поље :attribute je obavezno osim ako je vrednost polja :other :values.',
    'required_with' => 'Поље :attribute je obavezno kada je Поље :values prisutno.',
    'required_with_all' => 'Поље :attribute je obavezno kada su polja :values prisutna.',
    'required_without' => 'Поље :attribute je obavezno kada polja :values nisu prisutna.',
    'required_without_all' => 'Поље :attribute je obavezno kada nijedno od polja :values nije prisutno.',
    'same' => 'Polja :attribute i :other se ne poklapaju.',
    'size' => [
        'numeric' => 'Поље :attribute мора да буде :size.',
        'file' => 'Поље :attribute мора да буде :size kilobajta.',
        'string' => 'Поље :attribute mora da sadrži :size karaktera.',
        'array' => 'Поље :attribute mora da sadrži :size elementa.',
    ],
    'starts_with' => 'Поље :attribute mora da počne sa jednim od sledećih vrednosti: :values.',
    'string' => 'Поље :attribute мора да буде текст.',
    'timezone' => 'Поље :attribute mora da bude ispravna vremenska zona.',
    'unique' => 'Поље :attribute је већ заузето.',
    'uploaded' => 'Поље :attribute nije otpremljeno.',
    'url' => 'Поље :attribute мора да буде исправан УРЛ.',
    'uuid' => 'Поље :attribute mora da bude ispravan UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];