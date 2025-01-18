<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Helpers\Helper;
use App\Models\Ponuda_Date;

class Ponuda_PonudaID implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!Ponuda_Date::where('id_ponuda', $value)->where('worker_id', Helper::worker())->exists()) {
            $fail('The selected :attribute is invalid.');
        }
    }
}
