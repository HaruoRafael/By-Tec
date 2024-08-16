<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Aluno;
use App\Rules\CPF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AlunoController extends Controller
{
    public function index(Request $request)
    {
        $query = Aluno::query();

        if ($request->has('termo')) {
            $termo = strtolower($request->input('termo'));
            $query->where(DB::raw('LOWER(nome)'), 'LIKE', "%{$termo}%");
        }

        if ($request->has('cpf')) {
            $cpf = $request->input('cpf');
            $query->where('cpf', 'LIKE', "%{$cpf}%");
        }

        if ($request->has('status')) {
            $status = $request->input('status');

            if (!in_array('Removido', $status)) {
                $query->whereIn('status', $status);
            }
        }

        if (!in_array('Removido', $request->input('status', []))) {
            $query->where('status', '!=', 'Removido');
        }

        $query->with('status');

        $alunos = $query->orderBy('nome')->get();

        $alunos->each(function ($aluno) {
            $aluno->idade = $aluno->data_nascimento ? Carbon::parse($aluno->data_nascimento)->age : 'N/A';
        });

        return view('alunos.index', compact('alunos'));
    }

    public function create()
    {
        return view('alunos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => ['required', 'string', 'unique:alunos,cpf', new CPF],
            'rg' => 'nullable|string|max:255',
            'telefone' => 'nullable|string|max:20',
            'sexo' => 'required|in:M,F,Outro',
            'data_nascimento' => 'required|date',
            'endereco' => 'nullable|string',
        ], [
            'nome.required' => 'O campo nome é obrigatório.',
            'cpf.required' => 'O campo CPF é obrigatório.',
            'cpf.unique' => 'Já existe uma conta cadastrada com este CPF.',
            'sexo.required' => 'O campo sexo é obrigatório.',
            'data_nascimento.required' => 'O campo data de nascimento é obrigatório.',
        ]);

        Aluno::create([
            'nome' => $request->input('nome'),
            'cpf' => $request->input('cpf'),
            'rg' => $request->input('rg'),
            'telefone' => $request->input('telefone'),
            'sexo' => $request->input('sexo'),
            'data_nascimento' => $request->input('data_nascimento'),
            'endereco' => $request->input('endereco'),
        ]);

        return redirect()->route('alunos.index')->with('success', 'Aluno cadastrado com sucesso.');
    }

    public function show(Aluno $aluno)
    {
        return view('alunos.show', compact('aluno'));
    }

    public function edit(string $id)
    {
        // Verificação do cargo para impedir a edição
        if (Auth::user()->cargo === 'Professor') {
            return redirect()->route('alunos.show', $id)->with('error', 'Você não tem permissão para editar o perfil do aluno.');
        }

        $aluno = Aluno::findOrFail($id);
        return view('alunos.edit', compact('aluno'));
    }

    public function update(Request $request, string $id)
    {
        // Verificação do cargo para impedir a edição
        if (Auth::user()->cargo === 'Professor') {
            return redirect()->route('alunos.show', $id)->with('error', 'Você não tem permissão para editar o perfil do aluno.');
        }

        $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => ['required', new CPF],
            'rg' => 'nullable|string|max:255',
            'telefone' => 'nullable|string|max:20',
            'sexo' => 'required|in:M,F,Outro',
            'data_nascimento' => 'required|date',
            'endereco' => 'nullable|string',
            'status' => 'required|in:Ativo,Inativo,Pendente,Removido',
        ], [
            'nome.required' => 'O campo nome é obrigatório.',
            'cpf.required' => 'O campo CPF é obrigatório.',
            'cpf.unique' => 'Já existe uma conta cadastrada com este CPF.',
            'sexo.required' => 'O campo sexo é obrigatório.',
            'data_nascimento.required' => 'O campo data de nascimento é obrigatório.',
        ]);

        $aluno = Aluno::findOrFail($id);

        $aluno->nome = $request->input('nome');
        $aluno->cpf = $request->input('cpf');
        $aluno->rg = $request->input('rg');
        $aluno->telefone = $request->input('telefone');
        $aluno->sexo = $request->input('sexo');
        $aluno->data_nascimento = Carbon::parse($request->input('data_nascimento'));
        $aluno->endereco = $request->input('endereco');
        $aluno->status = $request->input('status');

        // Salva as alterações no banco de dados
        $aluno->save();

        return redirect()->route('alunos.show', $aluno->id)->with('success', 'Perfil do aluno atualizado com sucesso.');
    }

    public function destroy($id)
    {
        // Verificação do cargo para impedir a remoção
        if (Auth::user()->cargo === 'Professor') {
            return redirect()->route('alunos.show', $id)->with('error', 'Você não tem permissão para remover alunos.');
        }

        $aluno = Aluno::findOrFail($id);

        $aluno->status = 'Removido';
        $aluno->save();

        return redirect()->route('alunos.index')->with('success', 'Aluno removido com sucesso.');
    }

    public function remove($id)
    {
        // Verificação do cargo para impedir a remoção
        if (Auth::user()->cargo === 'Professor') {
            return redirect()->route('alunos.show', $id)->with('error', 'Você não tem permissão para remover alunos.');
        }

        $aluno = Aluno::findOrFail($id);

        $aluno->status = 'Removido';
        $aluno->save();

        return redirect()->route('alunos.index')->with('success', 'Aluno removido com sucesso.');
    }

    public function search(Request $request)
    {
        $termo = $request->input('termo');

        $termoMinusculo = strtolower($termo);

        $alunos = Aluno::whereRaw('LOWER(nome) LIKE ?', ["%{$termoMinusculo}%"])->get();

        return view('alunos.parcial.lista_alunos', compact('alunos'));
    }
}
