<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Premium extends Model
{
    use HasFactory;

    protected $table = 'premium';
    
    protected $fillable = [
        'worker_id',
        'premium_bought',
        'active',
    ];
}
