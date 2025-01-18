<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pozicija_Temporary extends Model
{
    use HasFactory;

    protected $table = 'pozicija_temporary';

    public $timestamps = false;

    protected $fillable = [
        'id_of_ponuda',
        'temporary_description',
    ];
}
