<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Ponuda_Date extends Model
{
    use HasFactory, HasTranslations;

    protected $table = 'ponuda_date';

    public $timestamps = true;

    protected $fillable = [
        'worker_id',
        'id_ponuda',
        'ponuda_name',
        'note',
        'opis',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $model) {
            $model->updated_at = null;
        });
    }

    public $translatable = ['ponuda_name','note','opis'];
}
