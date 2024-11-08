<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Tenta autenticar o usuário
        if (!Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            // Se a autenticação falhar, lança uma exceção com a mensagem personalizada
            throw ValidationException::withMessages([
                'email' => [__('A senha ou o email estão errados')], 
            ]);
        }

        // Verifica o status do usuário autenticado
        $user = Auth::user();
        if ($user->status === 'Desativado') {
            Auth::logout(); // Desloga o usuário desativado

            // Lança uma exceção com uma mensagem informando que a conta foi desativada
            throw ValidationException::withMessages([
                'email' => ['Sua conta foi desativada. Por favor, contate o administrador.'],
            ]);
        }

        // Se a autenticação for bem-sucedida e o usuário estiver ativo, redirecione para o local desejado
        return redirect()->intended('dashboard');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
