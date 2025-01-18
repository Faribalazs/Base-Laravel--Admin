<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pravno_lice_Temporary extends Model
{
    use HasFactory;
    
    protected $table = 'pravna_lica_temporary';

    public $timestamps = false;

    protected $fillable = [
        'worker_id',
        'company_name',
        'city',
        'zip_code',
        'address',
        'email',
        'tel',
        'pib',
    ];
}
