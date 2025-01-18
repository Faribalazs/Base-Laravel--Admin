<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Route;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if ($request->is($request->segment(1).'/admin/*')) {
            return route('admin.session.create');
        }
        if ($request->is($request->segment(1).'/contractor/*')) {
            return route('worker.session.create');
        }
        if (! $request->expectsJson()) {
            return route('login');
        }
    }
}
