<?php

namespace App\Http\Controllers\Adminauth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Adminauth\LoginRequest;
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
        if (auth()->guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        if (strpos(url()->previous(), 'admin') !== false) {
            $intendedUrl = url()->previous();
        } else {
            $intendedUrl = route('admin.dashboard');
        }

        session()->put('url.intended', $intendedUrl);

        return view('admin.views.admin-login');
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

        if (! auth()->guard('admin')->user()->status) {
            auth()->guard('admin')->logout();

            return redirect()->route('admin.session.create');
        }

        return redirect()->intended(route('admin.dashboard'));
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('admin')->logout();

        return redirect(route('admin.session.create'));
    }
}
