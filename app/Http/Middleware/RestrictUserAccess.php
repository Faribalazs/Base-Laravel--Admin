<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Ponuda;

class RestrictUserAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Ponuda::where('worker_id', auth('worker')->user()->id)->where('ponuda_id', $request->route('id'))->first() === null) {
            return response(view('unauthorizedAction'))->header('Refresh', '2; url=/'); // url=' . redirect()->back()->getTargetUrl()
        }

        return $next($request);
    }
}
