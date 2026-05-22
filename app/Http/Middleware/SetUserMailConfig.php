<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class SetUserMailConfig
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if ($user && method_exists($user, 'hasSmtpConfigured') && $user->hasSmtpConfigured()) {
            $smtp = $user->getSmtpConfig();

            Config::set('mail.mailers.smtp.host', $smtp['host']);
            Config::set('mail.mailers.smtp.port', $smtp['port']);
            Config::set('mail.mailers.smtp.username', $smtp['username']);
            Config::set('mail.mailers.smtp.password', $smtp['password']);
            Config::set('mail.mailers.smtp.encryption', $smtp['encryption']);
            Config::set('mail.from.address', $smtp['from_address']);
            Config::set('mail.from.name', $smtp['from_name']);

            // Reset mailer so the new config is used
            app()->forgetInstance('mail.manager');
            app()->forgetInstance('mailer');
        }

        return $next($request);
    }
}
