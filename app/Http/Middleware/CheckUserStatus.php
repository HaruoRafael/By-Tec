<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserStatus
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->status === 'Desativado') {
            Auth::logout();

            return redirect('/login')->withErrors(['status' => 'Sua conta foi desativada.']);
        }

        return $next($request);
    }
}
