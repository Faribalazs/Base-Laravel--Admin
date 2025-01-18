<?php

namespace App\Http\Controllers\Workerauth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Workerauth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        if (auth()->guard('worker')->check()) {
            return redirect()->route('worker.myprofile');
        }

        if (strpos(url()->previous(), 'worker') !== false) {
            $intendedUrl = url()->previous();
        } else {
            $intendedUrl = route('worker.myprofile');
        }

        session()->put('url.intended', $intendedUrl);

        return view('worker.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $this->validate(request(), [
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $request->authenticate();

        if (! auth()->guard('worker')->user()->status) {
            auth()->guard('admin')->logout();
            return redirect()->route('worker.session.create');
        }

        if (! auth()->guard('worker')->user()->hasVerifiedEmail()) {
            return redirect()->back();
        }

        return redirect()->intended(route('worker.myprofile'));
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('worker')->logout();

        return redirect(route('worker.session.create'));
    }
}
