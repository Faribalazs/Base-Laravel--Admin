<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Pravno_lice extends Model
{
    use HasFactory, HasTranslations;
    
    protected $table = 'pravna_lica';

    public $timestamps = false;

    protected $fillable = [
        'worker_id',
        'company_name',
        'city',
        'zip_code',
        'address',
        'email',
        'phone',
        'pib',
    ];

    public $translatable = ['company_name','city','address'];
}
