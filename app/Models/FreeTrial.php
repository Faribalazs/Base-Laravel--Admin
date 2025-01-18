<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FreeTrial extends Model
{
    use HasFactory;

    protected $table = 'free_trial';
    
    protected $fillable = [
        'worker_id',
        'count_offers',
        'count_my_categories',
    ];
}
