<?php

namespace App\Http\Controllers;

use Auth;
use Exception;
use Socialite;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class GoogleSocialiteController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToGoogle()
    {
        config(['services.google.redirect' => route('callback.google') ]);
        return Socialite::driver('google')->redirect();
    }
       
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleCallback()
    {
        config(['services.google.redirect' => route('callback.google') ]);
        try {
     
            $user = Socialite::driver('google')->user();
      
            $finduser = User::where('name', $user->name)->first();

      
            if($finduser){
      
                Auth::login($finduser);
     
                return redirect(route('home'));
      
            }else{
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'password' => Hash::make(Str::random(16))
                ]);
                $newUser->attachRole('user'); 
     
                Auth::login($newUser);
                
                $user = Auth::user();
                $user->email_verified_at = now();
                $user->save();

                return redirect(route('home'));
            }
     
        } catch (Exception) {
            alert()->error(__('app.controllers.something-went-wrong').' '.__('app.controllers.try-again'))->showCloseButton()->showConfirmButton('Close');
            return redirect()->route('home');
        }
    }
}
