<?php

namespace App\Http\Controllers;

use App\Models\Treino;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Aluno;
use App\Models\Venda;
use App\Rules\CPF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AlunoController extends Controller
{
    public function atualizarStatusAluno(Aluno $aluno)
    {
        $planoAtivo = $aluno->vendas()->where('status', 'Ativo')->exists();

        if ($planoAtivo) {
            $aluno->status = 'Ativo';
        } else {
            $ultimoPlano = $aluno->vendas()->latest('data_expiracao')->first();
            if ($ultimoPlano && $ultimoPlano->status === 'Cancelado') {
                $aluno->status = 'Inativo';
            } else {
                $aluno->status = 'Inativo';
            }
        }
        $aluno->save();
    }

    public function verificarExpiracaoPlanos()
    {
        try {
            $vendasExpiradas = Venda::where('status', 'Ativo')
                ->whereDate('data_expiracao', '<', Carbon::now())
                ->get();

            if ($vendasExpiradas->isEmpty()) {
                return;
            }
            foreach ($vendasExpiradas as $venda) {
                $venda->status = 'Finalizado';
                $venda->save();
                $this->atualizarStatusAluno($venda->aluno);
            }
        } catch (\Exception $e) {
            return;
        }
    }

    public function index(Request $request)
    {
        $this->verificarExpiracaoPlanos();

        $query = Aluno::query();

        if ($request->has('termo')) {
            $termo = strtolower($request->input('termo'));
            $query->where(DB::raw('LOWER(nome)'), 'LIKE', "%{$termo}%");
        }

        if ($request->has('cpf')) {
            $cpf = $request->input('cpf');
            $query->where('cpf', 'LIKE', "%{$cpf}%");
        }

        $status = $request->input('status', []);
        if (!empty($status)) {
            $query->whereIn('status', $status);
        }

        if (!in_array('Removido', $status)) {
            $query->where('status', '!=', 'Removido');
        }

        $alunos = $query->orderBy('nome')->paginate(10);

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
            'cpf' => ['required', new CPF],
            'rg' => 'nullable|string|max:255',
            'telefone' => 'nullable|string|max:20',
            'sexo' => 'required|in:Masculino,Feminino,Outro',
            'data_nascimento' => 'required|date',
            'endereco' => 'nullable|string',
        ], [
            'nome.required' => 'O campo nome é obrigatório.',
            'cpf.required' => 'O campo CPF é obrigatório.',
            'sexo.required' => 'O campo sexo é obrigatório.',
            'data_nascimento.required' => 'O campo data de nascimento é obrigatório.',
        ]);
        if (Aluno::where('cpf', $request->input('cpf'))->exists()) {
            return redirect()->back()->withErrors(['cpf' => 'Já existe uma conta com esse CPF.'])->withInput();
        }

        $aluno = Aluno::create([
            'nome' => $request->input('nome'),
            'cpf' => $request->input('cpf'),
            'rg' => $request->input('rg'),
            'telefone' => $request->input('telefone'),
            'sexo' => $request->input('sexo'),
            'data_nascimento' => $request->input('data_nascimento'),
            'endereco' => $request->input('endereco'),
        ]);

        $this->atualizarStatusAluno($aluno);

        return redirect()->route('alunos.index')->with('success', 'Aluno cadastrado com sucesso.');
    }

    public function show(Aluno $aluno)
    {
        $treinosDisponiveis = Treino::all();
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
            'sexo' => 'required|in:Masculino,Feminino,Outro',
            'data_nascimento' => 'required|date',
            'endereco' => 'nullable|string',
        ], [
            'nome.required' => 'O campo nome é obrigatório.',
            'cpf.required' => 'O campo CPF é obrigatório.',
            'sexo.required' => 'O campo sexo é obrigatório.',
            'data_nascimento.required' => 'O campo data de nascimento é obrigatório.',
        ]);

        if (Aluno::where('cpf', $request->input('cpf'))->where('id', '!=', $id)->exists()) {
            return redirect()->back()->withErrors(['cpf' => 'Já existe uma conta com esse CPF.'])->withInput();
        }

        $aluno = Aluno::findOrFail($id);

        $aluno->update([
            'nome' => $request->input('nome'),
            'cpf' => $request->input('cpf'),
            'rg' => $request->input('rg'),
            'telefone' => $request->input('telefone'),
            'sexo' => $request->input('sexo'),
            'data_nascimento' => $request->input('data_nascimento'),
            'endereco' => $request->input('endereco'),
        ]);

        $this->atualizarStatusAluno($aluno);

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


        $aluno->treinos()->attach($request->input('treino_id'));

        return redirect()->route('alunos.show', $aluno->id)->with('success', 'Treino adicionado com sucesso.');
    }

    public function removeTreino(Aluno $aluno, Treino $treino)
    {

        $aluno->treinos()->detach($treino->id);

        return redirect()->route('alunos.show', $aluno->id)->with('success', 'Treino removido do perfil do aluno com sucesso.');
    }
}
