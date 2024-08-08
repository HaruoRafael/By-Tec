<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'cpf' => ['required', 'string', 'max:14', 'unique:users'],
            'rg' => ['nullable', 'string', 'max:20'],
            'telefone' => ['nullable', 'string', 'max:20'],
            'sexo' => ['required', 'string', 'in:M,F,Outro'],
            'data_nascimento' => ['required', 'date'],
            'endereco' => ['nullable', 'string', 'max:255'],
            'cargo' => ['required', 'string', 'in:Professor,Recepcionista,Administrador'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $request->nome,
            'cpf' => $request->cpf,
            'rg' => $request->rg,
            'telefone' => $request->telefone,
            'sexo' => $request->sexo,
            'data_nascimento' => $request->data_nascimento,
            'endereco' => $request->endereco,
            'cargo' => $request->cargo,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('funcionarios.index')->with('success', 'Usuário cadastrado com sucesso!');
    }
}
