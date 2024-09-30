<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Google2FA
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->guard(view()->shared('auth_gaurd'))->user();
        
        if ($user->google2fa_secret && $request->session()->get('2fa_verified') == false) {
            return redirect()->route('otp_verify');
        }
        return $next($request);
    }
}
