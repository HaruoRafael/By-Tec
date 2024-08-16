<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserStatus
{
    public function handle(Request $request, Closure $next)
    {
        // Verifica se o usuário está autenticado e se o status é 'Desativado'
        if (Auth::check() && Auth::user()->status === 'Desativado') {
            Auth::logout(); // Faz logout do usuário

            // Redireciona para a página de login com uma mensagem de erro
            return redirect('/login')->withErrors(['status' => 'Sua conta foi desativada.']);
        }

        // Continua a requisição normalmente se o usuário não estiver desativado
        return $next($request);
    }
}
