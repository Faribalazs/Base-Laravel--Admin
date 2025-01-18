<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\{User, Worker, Admin};

class UniqueEmail implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (User::where('email', $value)->exists() || Worker::where('email', $value)->exists() || Admin::where('email', $value)->exists()) {
            $fail(__('app.controllers.email-address-is-occupied'));
        }
    }
}
