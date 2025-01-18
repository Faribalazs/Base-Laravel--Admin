<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Units extends Model
{
    use HasFactory, HasTranslations;

    protected $table = 'units';

    protected $primaryKey = 'id_unit';

    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    public $translatable = ['name'];
}
