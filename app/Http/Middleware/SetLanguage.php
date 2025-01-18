<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Helpers\Helper;

class SetLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        $locale = $request->segment(1);

        if(!in_array($locale, config('app.locales'))) {
           return redirect(url(Helper::getCurrentUrlWithLocale(config('app.fallback_locale'))));
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
