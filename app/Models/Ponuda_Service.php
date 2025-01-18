<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Ponuda_Service extends Model
{
    use HasFactory, HasTranslations;

    protected $table = 'services';

    public $timestamps = false;
    
    protected $fillable = [
        'name_service',
    ];

    public $translatable = ['name_service'];
}
