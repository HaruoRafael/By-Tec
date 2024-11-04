<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\CPF;
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
            'cpf' => ['required', 'string', 'max:14', 'unique:users', new CPF],
            'rg' => ['nullable', 'string', 'max:20'],
            'telefone' => ['nullable', 'string', 'max:20'],
            'sexo' => ['required', 'string', 'in:Masculino,Feminino,Outro'],
            'data_nascimento' => ['required', 'date'],
            'endereco' => ['nullable', 'string', 'max:255'],
            'cargo' => ['required', 'string', 'in:Professor,Recepcionista,Administrador'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'nome.required' => 'O nome é obrigatório.',
            'cpf.required' => 'O CPF é obrigatório.',
            'cpf.unique' => 'Este CPF já está em uso.',
            'rg.max' => 'O RG não pode ter mais de 20 caracteres.',
            'telefone.max' => 'O telefone não pode ter mais de 20 caracteres.',
            'sexo.required' => 'O campo sexo é obrigatório.',
            'sexo.in' => 'O sexo deve ser Masculino, Feminino ou Outro.',
            'data_nascimento.required' => 'A data de nascimento é obrigatória.',
            'data_nascimento.date' => 'A data de nascimento deve ser uma data válida.',
            'endereco.max' => 'O endereço não pode ter mais que 255 caracteres.',
            'cargo.required' => 'O cargo é obrigatório.',
            'cargo.in' => 'O cargo deve ser Professor, Recepcionista ou Administrador.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'O e-mail deve ser um endereço de e-mail válido.',
            'email.unique' => 'Este e-mail já está em uso.',
            'password.required' => 'A senha é obrigatória.',
            'password.min' => 'A senha deve ter pelo menos 8 caracteres.',
            'password.confirmed' => 'A confirmação da senha não confere.',
        ]);
        $sexo = match ($request->sexo) {
            'Masculino' => 'Masculino',
            'Feminino' => 'Feminino',
            'Outro' => 'Outro',
        };
        
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
