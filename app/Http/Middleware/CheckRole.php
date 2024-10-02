<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$roles
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        // Verifica se o usuário está autenticado e se seu cargo está na lista permitida
        if ($user && in_array($user->cargo, $roles)) {
            return $next($request);
        }

        // Redireciona para a página de acesso negado se o usuário não tiver permissão
        return redirect()->route('access.denied');
    }
}
