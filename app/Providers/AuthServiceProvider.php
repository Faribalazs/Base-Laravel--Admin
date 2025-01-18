<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            if ($notifiable->getGuard() == 'worker') {
                $worker_url = URL::temporarySignedRoute(
                    'worker.verification.verify',
                    Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
                    [
                        'id' => $notifiable->getKey(),
                        'hash' => sha1($notifiable->getEmailForVerification()),
                    ]);
                return (new MailMessage)
                    ->subject('Verify Email Address')
                    ->view('emails.email-verification', ['url'=> $worker_url]);
            }
            return (new MailMessage)
                ->subject('Verify Email Address')
                ->view('emails.email-verification', ['url'=> $url]);
        });

        ResetPassword::toMailUsing(function (object $notifiable, string $url) {
            if ($notifiable->getGuard() == 'worker') {
            return (new MailMessage)
                ->subject('Reset password')
                ->view('worker.emails.reset-password', ['url'=> $url, 'notifiable' => $notifiable]);
            }
            return (new MailMessage)
                ->subject('Reset password')
                ->view('emails.reset-password', ['url'=> $url, 'notifiable' => $notifiable]);
        });

    }
}
