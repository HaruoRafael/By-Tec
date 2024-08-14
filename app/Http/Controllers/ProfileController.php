<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use App\Models\User;

class ProfileController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::query();

        if ($request->has('termo')) {
            $termo = strtolower($request->input('termo'));
            $query->where(DB::raw('LOWER(name)'), 'LIKE', "%{$termo}%");
        }

        if ($request->has('cpf')) {
            $cpf = $request->input('cpf');
            $query->where('cpf', 'LIKE', "%{$cpf}%");
        }

        if ($request->has('status')) {
            $status = $request->input('status');
            $query->whereIn('status', $status);
        } else {
            // Se nenhum status for selecionado, exibir apenas funcionários ativos
            $query->where('status', 'Ativo');
        }

        $funcionarios = $query->orderBy('name')->get();

        return view('funcionarios.index', compact('funcionarios'));
    }
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'cpf' => ['required', 'string', 'max:14', 'unique:users,cpf,' . $user->id],
            'rg' => ['nullable', 'string', 'max:20'],
            'telefone' => ['nullable', 'string', 'max:15'],
            'sexo' => ['required', 'in:M,F,Outro'],
            'data_nascimento' => ['required', 'date'],
            'endereco' => ['nullable', 'string', 'max:255'],
            'cargo' => ['required', 'string', 'in:Professor,Recepcionista,Administrador'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'status' => ['required', 'in:Ativo,Desativado'], // Validação do status
        ]);

        if ($validator->fails()) {
            return Redirect::route('funcionarios.show', $user->id)
                ->withErrors($validator)
                ->withInput();
        }

        $user->fill($request->except('password'));

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('funcionarios.show', $user->id)->with('status', 'profile-updated');
    }

    public function destroy($id): RedirectResponse
    {
        $user = User::findOrFail($id);

        $user->status = 'Desativado';
        $user->save();

        return Redirect::route('funcionarios.index')->with('success', 'Funcionário desativado com sucesso.');
    }

    public function show(User $user): View
    {
        return view('funcionarios.show', [
            'user' => $user,
        ]);
    }
    public function remove(User $user): RedirectResponse
    {
        // Atualiza o status do usuário para 'Desativado'
        $user->status = 'Desativado';
        $user->save();

        // Redireciona de volta para a lista de funcionários com uma mensagem de sucesso
        return Redirect::route('funcionarios.index')->with('success', 'Funcionário desativado com sucesso.');
    }
    public function reativar(User $user): RedirectResponse
{
    // Atualiza o status do usuário para 'Ativo'
    $user->status = 'Ativo';
    $user->save();

    // Redireciona de volta para a página de detalhes do funcionário com uma mensagem de sucesso
    return Redirect::route('funcionarios.show', $user->id)->with('success', 'Funcionário reativado com sucesso.');
}

}
