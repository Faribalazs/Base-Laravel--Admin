<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Translatable\HasTranslations;

class Company_Data extends Model
{
    use HasFactory, HasTranslations;
    use LogsActivity;

    protected $table = 'company_data';
    
    public $timestamps = false;

    protected $fillable = [
        'worker_id',
        'company_name',
        'country',
        'city',
        'zip_code',
        'address',
        'tel',
        'email',
        'phone',
        'pib',
        'maticni_broj',
        'tekuci_racun',
        'bank_name',
        'logo',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('company')
            ->logOnlyDirty();
    }
    
    public $translatable = ['company_name', 'city', 'country', 'address'];

    // protected static $logAttributes = ['name', 'password'];
}
