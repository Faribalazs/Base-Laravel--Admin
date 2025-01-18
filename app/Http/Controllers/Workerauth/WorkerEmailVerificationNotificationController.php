<?php

namespace App\Http\Controllers\Workerauth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use App\Models\Worker;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Contracts\Encryption\DecryptException;

class WorkerEmailVerificationNotificationController extends Controller
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
            'mama' => 'required'
        ]);
        try{
            $decrypted_id = decrypt(substr($request->mama, 4));
        } catch(DecryptException){
            Alert::error(__('app.controllers.something-went-wrong'))->showCloseButton()->showConfirmButton(__('app.basic.close'));
            return redirect()->back();
        }
        
        $user = Worker::find($decrypted_id);

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
    }
}
