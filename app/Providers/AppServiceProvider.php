<?php
namespace App\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function () {
            $user = Auth::user();
            if ($user && $user->hasSmtpConfigured()) {
                $this->setUserMailConfig($user);
            }
        });
    }

    /**
     * Set mail configuration for a specific user
     */
    public static function setUserMailConfig($user)
    {
        if ($user && $user->hasSmtpConfigured()) {
            $smtp = $user->getSmtpConfig();

            Config::set('mail.mailers.smtp.host', $smtp['host']);
            Config::set('mail.mailers.smtp.port', $smtp['port']);
            Config::set('mail.mailers.smtp.username', $smtp['username']);
            Config::set('mail.mailers.smtp.password', $smtp['password']);
            Config::set('mail.mailers.smtp.encryption', $smtp['encryption']);
            Config::set('mail.from.address', $smtp['from_address']);
            Config::set('mail.from.name', $smtp['from_name']);

            // Forget the mailer so it uses the new config
            app()->forgetInstance('mailer');
            app()->forgetInstance(\Illuminate\Mail\Mailer::class);
            app()->forgetInstance('mail.manager'); // For Laravel 8/9+
            
            return true;
        }
        
        return false;
    }
}
