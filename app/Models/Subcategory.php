<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Subcategory extends Model
{
    use HasFactory, HasTranslations;

    protected $table = 'custom_subcategories';

    public $timestamps = false;
    
    protected $fillable = [
        'worker_id',
        'custom_category_id',
        'name',
    ];

    public $translatable = ['name'];
}
