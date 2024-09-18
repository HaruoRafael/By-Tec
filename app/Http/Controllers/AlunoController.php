<?php

namespace App\Http\Controllers;

use App\Models\Treino;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Aluno;
use App\Models\Venda; // Importar o modelo Venda
use App\Rules\CPF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AlunoController extends Controller
{
    // Função para atualizar o status do aluno baseado nos planos ativos
    public function atualizarStatusAluno(Aluno $aluno)
{
    // Verifica se o aluno tem algum plano com status 'Ativo'
    $planoAtivo = $aluno->vendas()->where('status', 'Ativo')->exists();

    if ($planoAtivo) {
        // Se o aluno tiver um plano ativo, o status do aluno será 'Ativo'
        $aluno->status = 'Ativo';
    } else {
        // Caso todos os planos estejam finalizados ou cancelados, o status do aluno será 'Inativo'
        $planoFinalizadoOuCancelado = $aluno->vendas()->whereIn('status', ['Finalizado', 'Cancelado'])->exists();

        if ($planoFinalizadoOuCancelado) {
            $aluno->status = 'Inativo';
        } else {
            // Caso o aluno não tenha nenhum plano ativo ou finalizado, o status será 'Inativo'
            $aluno->status = 'Inativo';
        }
    }

    // Salva as mudanças no status do aluno
    $aluno->save();
}

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

        $aluno = Aluno::create([
            'nome' => $request->input('nome'),
            'cpf' => $request->input('cpf'),
            'rg' => $request->input('rg'),
            'telefone' => $request->input('telefone'),
            'sexo' => $request->input('sexo'),
            'data_nascimento' => $request->input('data_nascimento'),
            'endereco' => $request->input('endereco'),
        ]);

        // Atualiza o status do aluno ao criar
        $this->atualizarStatusAluno($aluno);

        return redirect()->route('alunos.index')->with('success', 'Aluno cadastrado com sucesso.');
    }

    public function show(Aluno $aluno)
    {
        $treinosDisponiveis = Treino::all(); // Recupera todos os treinos disponíveis
        return view('alunos.show', compact('aluno', 'treinosDisponiveis'));
    }

    public function edit(string $id)
    {
        if (Auth::user()->cargo === 'Professor') {
            return redirect()->route('alunos.show', $id)->with('error', 'Você não tem permissão para editar o perfil do aluno.');
        }

        $aluno = Aluno::findOrFail($id);
        return view('alunos.edit', compact('aluno'));
    }

    public function update(Request $request, string $id)
    {
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
        $aluno->update($request->all());

        // Atualiza o status do aluno após a edição

        return redirect()->route('alunos.show', $aluno->id)->with('success', 'Perfil do aluno atualizado com sucesso.');
    }

    public function destroy($id)
    {
        if (Auth::user()->cargo === 'Professor') {
            return redirect()->route('alunos.show', $id)->with('error', 'Você não tem permissão para remover alunos.');
        }

        $aluno = Aluno::findOrFail($id);
        $aluno->vendas()->where('status', 'Ativo')->update(['status' => 'Cancelado']);
        $aluno->update(['status' => 'Removido']);
        return redirect()->route('alunos.index')->with('success', 'Aluno removido com sucesso.');
    }

    public function remove($id)
    {
        $aluno = Aluno::findOrFail($id);
        $aluno->vendas()->where('status', 'Ativo')->update(['status' => 'Cancelado']);
        $aluno->status = 'Removido';
        $aluno->save();
        return redirect()->route('alunos.index')->with('success', 'Aluno removido com sucesso.');
    }

    public function reativar($id)
    {
        $aluno = Aluno::findOrFail($id);

        $aluno->status = 'Inativo';
        $aluno->save();

        $this->atualizarStatusAluno($aluno);

        return redirect()->route('alunos.index')->with('success', 'Aluno reativado com sucesso.');
    }

    public function search(Request $request)
    {
        $termo = strtolower($request->input('termo'));

        $alunos = Aluno::whereRaw('LOWER(nome) LIKE ?', ["%{$termo}%"])->get();

        return view('alunos.parcial.lista_alunos', compact('alunos'));
    }

    public function addTreino(Request $request, Aluno $aluno)
    {
        $request->validate([
            'treino_id' => 'required|exists:treinos,id',
        ]);

        // Associa o treino ao aluno
        $aluno->treinos()->attach($request->input('treino_id'));

        return redirect()->route('alunos.show', $aluno->id)->with('success', 'Treino adicionado com sucesso.');
    }

    public function removeTreino(Aluno $aluno, Treino $treino)
    {
        // Remove a associação entre o aluno e o treino
        $aluno->treinos()->detach($treino->id);

        return redirect()->route('alunos.show', $aluno->id)->with('success', 'Treino removido do perfil do aluno com sucesso.');
    }
}
