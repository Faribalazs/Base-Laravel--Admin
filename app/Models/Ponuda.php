<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Ponuda extends Model
{
    use HasFactory, HasTranslations;

    protected $table = 'ponuda';

    public $timestamps = false;
    
    protected $fillable = [
        'worker_id',
        'ponuda_id',
        'work_type_id',
        'categories_id',
        'subcategories_id',
        'pozicija_id',
        'service_id',
        'quantity',
        'unit_price',
    ];

    public $translatable = ['title', 'description','name_category','name_custom_category','name_service','unit_name','title','description','work_type_name','custom_work_type_name','custom_title','custom_description'];

}
