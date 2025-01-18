<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Default_subcategory extends Model
{
    use HasFactory, HasTranslations;

    protected $table = 'subcategories';

    public $timestamps = false;

    protected $fillable = [
        'category_id',
        'name',
    ];

    public $translatable = ['name'];
}
