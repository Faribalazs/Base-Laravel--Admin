<?php

namespace App\Http\Controllers\Workerauth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

class WorkerEmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function __invoke(Request $request)
    {
        // dd($request);
        // if (!$request->session()->has('status')) {
        //     $request->user('worker')->sendEmailVerificationNotification();
        // }
        // return $request->user()->hasVerifiedEmail()
        //             ? redirect()->intended(route('worker.myprofile'))
        //             : view('worker.auth.verify-email');
    }
}
