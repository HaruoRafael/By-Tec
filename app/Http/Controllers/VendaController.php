<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venda;
use App\Models\Aluno;
use App\Models\Plano;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;  // Usado para manipular datas

class VendaController extends Controller
{
    public function create(Request $request)
    {
        $aluno = Aluno::find($request->input('aluno_id'));
        $planos = Plano::all();

        $venda_atual = $aluno->vendas()->where('status', 'Ativo')->first();

        if ($venda_atual) {
            // Se o aluno tiver um plano ativo, redireciona com uma mensagem de erro
            return redirect()->route('alunos.show', $aluno->id)
                ->with('error', 'O aluno já possui um plano ativo. Não é possível realizar outra venda.');
        }

        return view('vendas.create', compact('aluno', 'planos'));
    }

    public function store(Request $request)
    {
        // Recupera o valor do plano
        $plano = Plano::find($request->input('plano_id'));
        $valor_original = $plano->valor;

        // Aplica desconto se houver
        $desconto = $request->input('desconto', 0);
        $valor_final = $valor_original * (1 - ($desconto / 100));

        // Define a data de início como hoje
        $data_inicio = Carbon::today(); // Garante que a data de início seja hoje

        // Calcula a data de expiração com base na duração do plano
        $data_expiracao = $data_inicio->copy()->addMonths($plano->duracao);  // Adiciona a duração do plano à data de início

        // Cria a venda e associa o usuário logado
        $venda = new Venda();
        $venda->descricao = $request->input('descricao');
        $venda->data = $data_inicio;  // Usa a data de hoje
        $venda->valor = $valor_final;
        $venda->forma_pagamento = $request->input('forma_pagamento');
        $venda->aluno_id = $request->input('aluno_id');
        $venda->plano_id = $request->input('plano_id');
        $venda->user_id = Auth::id();
        $venda->data_expiracao = $data_expiracao;  // Define a data de expiração do plano
        $venda->save();

        return redirect()->route('alunos.show', $venda->aluno_id)->with('success', 'Venda realizada com sucesso!');
    }

    public function show($id)
    {
        $aluno = Aluno::findOrFail($id); // Busca o aluno pelo ID
        $contratos = $aluno->vendas()->orderBy('data', 'desc')->get(); // Pega todas as vendas do aluno

        return view('alunos.show', compact('aluno', 'contratos')); // Passa 'aluno' e 'contratos' para a view
    }

    public function finalizar($id)
    {
        $venda = Venda::findOrFail($id);
        $venda->status = 'Finalizado';
        $venda->save();

        // Atualiza o status do aluno para "Inativo" se não houver mais planos ativos
        $this->atualizarStatusAluno($venda->aluno_id);

        return redirect()->route('alunos.show', $venda->aluno_id)->with('success', 'Plano finalizado com sucesso!');
    }

    public function cancelar($id)
    {
        $venda = Venda::findOrFail($id);
        $venda->status = 'Cancelado';
        $venda->save();

        // Atualiza o status do aluno para "Inativo" ou "Cancelado" se necessário
        $this->atualizarStatusAluno($venda->aluno_id);

        return redirect()->route('alunos.show', $venda->aluno_id)->with('success', 'Plano cancelado com sucesso!');
    }

    private function atualizarStatusAluno($aluno_id)
    {
        $aluno = Aluno::findOrFail($aluno_id);

        // Verifica se o aluno tem algum plano ativo
        $planoAtivo = $aluno->vendas()->where('status', 'Ativo')->exists();

        if ($planoAtivo) {
            $aluno->status = 'Ativo'; // Se tiver plano ativo, aluno fica "Ativo"
        } else {
            // Se o aluno não tiver planos ativos, verifica se foi removido ou se o plano expirou
            $ultimoPlano = $aluno->vendas()->latest('data_expiracao')->first();
            if ($ultimoPlano && $ultimoPlano->status === 'Cancelado') {
                $aluno->status = 'Cancelado';
            } else {
                $aluno->status = 'Inativo'; // Sem plano ativo, aluno fica "Inativo"
            }
        }

        $aluno->save();
    }
}
