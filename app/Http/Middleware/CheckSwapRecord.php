<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Ponuda;

class CheckSwapRecord
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(auth('worker')->check())
        {
            $worker = auth('worker')->user();
            if(Ponuda::where('worker_id', $worker->id)->where('ponuda_id', $worker->ponuda_counter)->first() && !request()->routeIs("worker.archive.selected"))
            {
                return redirect()->route('worker.new.ponuda')->with('accessDenied', __('app.controllers.finish-ponuda-first'));
            }
        }
        return $next($request);
    }
}
