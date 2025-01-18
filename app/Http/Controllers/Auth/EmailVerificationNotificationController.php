<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Contracts\Encryption\DecryptException;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_mama' => 'required'
        ]);
        try{
            $decrypted_id = decrypt(substr($request->user_mama, 4));
        } catch(DecryptException){
            Alert::error(__('app.controllers.something-went-wrong'))->showCloseButton()->showConfirmButton(__('app.basic.close'));
            return redirect()->back();
        }
        
        $user = User::find($decrypted_id);

        if($user)
        {
            if ($user->hasVerifiedEmail()) {
                return redirect()->intended(route('worker.myprofile'));
            }

            $user->sendEmailVerificationNotification();

            Alert::success(__('app.auth.e-mail-sent'))->showCloseButton()->showConfirmButton(__('app.basic.close'));
            return redirect()->back();
        }

        return redirect()->back()->with('error',__('app.controllers.something-went-wrong'));

        // if ($request->user()->hasVerifiedEmail()) {
        //     return redirect()->intended(route('home'));
        // }

        // $request->user()->sendEmailVerificationNotification();

        // return back()->with('status', 'verification-link-sent');
    }
}
