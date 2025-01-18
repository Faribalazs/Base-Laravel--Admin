<?php

namespace App\Helpers;

use App\Models\FreeTrial;

class Helper
{
    public static function getCurrentUrlWithLocale(string $locale) {

        $segments = request()->segments();
        $segments[0] = $locale;

        return implode('/', $segments);
    }

    public static function worker()
    {
        return auth('worker')->user()->id ?? null;
    }

    public static function transliterate($text, $direction = "sr", $canBeNull = 0)
    {
        if (empty($text)) {
            if($canBeNull){
                return null;
            }

            return "&nbsp;";
        }

        $textLength = mb_strlen($text, 'UTF-8');

        if ($textLength === 0) {
            return $text;
        }

        $cyrillicCount = preg_match_all('/[\p{Cyrillic}]/u', $text);
        $percentageCyrillic = ($cyrillicCount / $textLength) * 100;

        $sourceLanguage = ($percentageCyrillic >= 75) ? "rs-cyrl" : "sr";

        if ($sourceLanguage === $direction) {
            return $text;
        }

        $latin = ['NJ', 'LJ', 'Nj', 'Lj', 'nj', 'lj', 'nJ', 'lJ', 'a', 'b', 'v', 'g', 'd', 'đ', 'e', 'ž', 'z', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'ć', 'u', 'f', 'h', 'c', 'č', 'š', 'A', 'B', 'V', 'G', 'D', 'Đ', 'E', 'Ž', 'Z', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'Ć', 'U', 'F', 'H', 'C', 'Č', 'Š'];
        $cyrillic = ['Њ', 'Љ', 'Њ', 'Љ', 'њ', 'љ', 'њ', 'љ', 'а', 'б', 'в', 'г', 'д', 'ђ', 'е', 'ж', 'з', 'и', 'ј', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'ћ', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'А', 'Б', 'В', 'Г', 'Д', 'Ђ', 'Е', 'Ж', 'З', 'И', 'Ј', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'Ћ', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш'];

        return ($sourceLanguage === "sr") ? str_replace($latin, $cyrillic, $text) : str_replace($cyrillic, $latin, $text);
    }
    public static function updateFreeTrial($type){
        if($type === "count_offers" || $type === "count_my_categories")
        {
            \App\Models\FreeTrial::where('worker_id', self::worker())->increment($type);
        }
    }
}