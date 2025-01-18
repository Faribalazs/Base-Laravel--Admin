<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function __invoke(Request $request)
    {
        // if (!$request->session()->has('status')) {
        //     $request->user()->sendEmailVerificationNotification();
        // }
        // return $request->user()->hasVerifiedEmail()
        //             ? redirect()->intended(route('home'))
        //             : view('auth.verify-email');
    }
}
