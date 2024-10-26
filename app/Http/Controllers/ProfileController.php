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
use App\Http\Requests\ProfileUpdateRequest;

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
            $query->where('status', 'Ativo');
        }

        $funcionarios = $query->orderBy('name')->paginate(10);

        return view('funcionarios.index', compact('funcionarios'));
    }
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request, User $user): RedirectResponse
    {
        $user->fill($request->validated());
    
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
    
        $user->save();
    
        return Redirect::route('funcionarios.show', $user->id)->with('status', 'Funcionário atualizado com sucesso');
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
        $user->status = 'Desativado';
        $user->save();

        return Redirect::route('funcionarios.index')->with('success', 'Funcionário desativado com sucesso.');
    }
    public function reativar(User $user): RedirectResponse
    {
        $user->status = 'Ativo';
        $user->save();

        return Redirect::route('funcionarios.show', $user->id)->with('success', 'Funcionário reativado com sucesso.');
    }
}
