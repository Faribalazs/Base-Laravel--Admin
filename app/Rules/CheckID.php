<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Helpers\Helper;

class CheckID implements ValidationRule
{
    protected $firstModel;
    protected $secondModel;

    public function __construct(string $firstModel, string $secondModel)
    {
        $this->firstModel = $firstModel;
        $this->secondModel = $secondModel;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $default_Model = $this->firstModel::where('id', $value)
            ->exists();
        
        $custom_Model = $this->secondModel::where('id', $value)
            ->where('worker_id', Helper::worker())
            ->exists();

        if (!$default_Model && !$custom_Model) {
            $fail('The selected :attribute is invalid.');
        }
    }
}
