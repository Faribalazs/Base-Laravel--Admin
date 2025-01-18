<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Browser;

class Tracker extends Model
{
    use HasFactory;

    public $attributes = [ 'hits' => 0 ];

    protected $fillable = [ 'ip', 'worker_id', 'date', 'device', 'browser'];

    public $timestamps = false;

    protected $table = 'worker_tracker';

    public static function boot() {
        // When a new instance of this model is created...
        parent::boot();
        static::creating(function ($tracker) {
            $tracker->hits = 0;
        } );
        // Any time the instance is updated (but not created)
        static::saving(function ($tracker) {
            $tracker->visit_date = date('Y-m-d');
            $tracker->visit_time = date('H:i:s');
            $tracker->hits++;
        } );
    }

    public static function hit() {
        try {
            $deviceType = 'unknown';

            if (Browser::isMobile()) {
                $deviceType = 'mobile';
            } elseif (Browser::isTablet()) {
                $deviceType = 'tablet';
            } elseif (Browser::isDesktop()) {
                $deviceType = 'desktop';
            } elseif (Browser::isBot()) {
                $deviceType = 'bot';
            }     

            $browserType = 'unknown';

            if (Browser::isChrome()) {
                $browserType = 'chrome';
            } elseif (Browser::isFirefox()) {
                $browserType = 'firefox';
            } elseif (Browser::isOpera()) {
                $browserType = 'opera';
            } elseif (Browser::isSafari()) {
                $browserType = 'safari';
            } elseif (Browser::isIE()) {
                $browserType = 'ie';
            } elseif (Browser::isEdge()) {
                $browserType = 'edge';
            }
            
            static::firstOrCreate([
                'ip' => request()->ip() ?? '0.0.0.0',
                'worker_id' => auth('worker')->user()->id,
                'visit_date' => date('Y-m-d'),
                'device' => $deviceType,
                'browser' => $browserType,
            ])->save();
        } catch (\Exception) {
            //should be empty
        }
    }

    public function worker()
    {
        return $this->belongsTo(Worker::class, 'worker_id')->select('first_name','last_name');
    }
}
