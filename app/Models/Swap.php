<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Swap extends Model
{
    use HasFactory, HasTranslations;

    protected $table = 'swap_ponuda';

    public $timestamps = false;

    protected $fillable = [
        'worker_id',
        'original_id',
        'swap_id',
        'temp_ponuda_name',
        'temp_note',
        'temp_opis',
    ];

    public $translatable = ['temp_ponuda_name','temp_note','temp_opis'];
}
