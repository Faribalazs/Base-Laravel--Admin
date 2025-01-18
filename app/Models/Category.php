<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasFactory, HasTranslations;

    protected $table = 'custom_categories';

    public $timestamps = false;
    
    protected $fillable = [
        'custom_work_type_id',
        'name',
        'worker_id',
    ];

    public $translatable = ['name'];
}
