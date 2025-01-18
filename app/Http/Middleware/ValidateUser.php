<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = null;
        if (auth()->check()) {
            $user = auth();
            $route = 'login';
            $session_key = 'user_mama';
        }
        elseif(auth('worker')->check()){
            $user = auth('worker');
            $route = 'worker.session.create';
            $session_key = 'mama';
        }
        if(isset($user))
        {
            $userdata = $user->user();
            if (!$userdata->hasVerifiedEmail() || $userdata->status == 0) {
                $user->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                if(!$userdata->hasVerifiedEmail()){
                    if($session_key != null)
                    {
                        return redirect()->route($route)->with('error-email', __('app.email.verify-email'))->with($session_key, encrypt($userdata->id));
                    }
                    else
                    {
                        return redirect()->route($route)->with('error', __('app.controllers.something-went-wrong'));
                    }
                }
                else{
                    return redirect()->route($route)->with('error', __('app.email.banned'));
                }
            }
        }

        return $next($request);
    }
}
