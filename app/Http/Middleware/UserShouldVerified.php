<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class UserShouldVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        if (Auth::check() && !Auth::user()->is_verified) {
            $link = url('auth/send-verification').'?email='.urlencode(Auth::user()->email);
            Auth::logout();

            Session::flash("flash_notification", [
                "level" => "warning",
                "message" => "Please kindly activate your account, Check your e-mail
                <a class='alert-link' href='$link'> Re-send </a>"
                ]);
            return redirect('/login');
        }
        return $response;
    }
}
