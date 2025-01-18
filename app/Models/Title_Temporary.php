<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Title_Temporary extends Model
{
    use HasFactory;

    protected $table = 'title_temporary';

    public $timestamps = false;

    protected $fillable = [
        'id_of_ponuda',
        'temporary_title',
    ];
}
