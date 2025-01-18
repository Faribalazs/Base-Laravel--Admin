<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\{FreeTrial, Premium};
use App\Helpers\Helper;

class FreeTrialMyCategories
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(FreeTrial::where('worker_id', Helper::worker())->first()->count_my_categories >= 10) 
        {
            $premium = Premium::where('worker_id', Helper::worker())->first();
    
            if (!$premium || !$premium->active) {
                return redirect()->back()->with('buy_premium', 'You need to buy premium.');            
            }
        }

        return $next($request);
    }
}
