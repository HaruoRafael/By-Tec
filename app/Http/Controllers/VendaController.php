<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venda;
use App\Models\Aluno;
use App\Models\Plano;
use App\Models\Caixa;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;  // Usado para manipular datas

class VendaController extends Controller
{
    public function create(Request $request)
    {
        $aluno = Aluno::find($request->input('aluno_id'));
        $planos = Plano::all();

        // Verifica se o aluno já tem um plano ativo
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
        // Verifica se há um caixa aberto
        $caixa = Caixa::where('status', 'aberto')->first();

        if (!$caixa) {
            return redirect()->back()->with('error', 'Nenhum caixa aberto encontrado.');
        }

        // Recupera o valor do plano
        $plano = Plano::find($request->input('plano_id'));
        $valor_original = $plano->valor;

        // Aplica desconto se houver
        $desconto = $request->input('desconto', 0);
        $valor_final = $valor_original * (1 - ($desconto / 100));

        // Define a data de início como hoje
        $data_inicio = Carbon::today();

        // Calcula a data de expiração com base na duração do plano
        $data_expiracao = $data_inicio->copy()->addMonths($plano->duracao);

        // Cria a venda e associa o usuário logado e o caixa aberto
        $venda = new Venda();
        $venda->descricao = $request->input('descricao');
        $venda->data = $data_inicio;
        $venda->valor = $valor_final;
        $venda->forma_pagamento = $request->input('forma_pagamento');
        $venda->aluno_id = $request->input('aluno_id');
        $venda->plano_id = $request->input('plano_id');
        $venda->user_id = Auth::id();
        $venda->data_expiracao = $data_expiracao;
        $venda->caixa_id = $caixa->id;  // Associa a venda ao caixa aberto
        $venda->save();

        // Atualiza o status do aluno após a venda
        $this->atualizarStatusAluno($venda->aluno_id);

        return redirect()->route('alunos.show', $venda->aluno_id)->with('success', 'Venda realizada com sucesso!');
    }

    public function show($id)
    {
        $aluno = Aluno::findOrFail($id);
        $contratos = $aluno->vendas()->orderBy('data', 'desc')->get();

        return view('alunos.show', compact('aluno', 'contratos'));
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

        // Recupera o caixa relacionado à venda
        $caixa = Caixa::findOrFail($venda->caixa_id);

        // Verifica se o caixa está aberto
        if ($caixa->status !== 'aberto') {
            return redirect()->back()->with('error', 'O caixa já está fechado.');
        }

        // Diminui o valor da venda do saldo inicial do caixa
        $caixa->saldo_inicial -= $venda->valor;

        // Atualiza o saldo inicial no banco de dados
        $caixa->save();

        // Atualiza o status da venda para 'Cancelado'
        $venda->status = 'Cancelado';
        $venda->save();

        // Atualiza o status do aluno
        $this->atualizarStatusAluno($venda->aluno_id);

        return redirect()->route('caixas.show', $caixa->id)->with('success', 'Venda cancelada e removida do caixa com sucesso.');
    }


    // Função para atualizar o status do aluno com base nas vendas ativas
    private function atualizarStatusAluno($aluno_id)
    {
        $aluno = Aluno::findOrFail($aluno_id);

        // Verifica se o aluno tem algum plano ativo
        $planoAtivo = $aluno->vendas()->where('status', 'Ativo')->exists();

        if ($planoAtivo) {
            $aluno->status = 'Ativo';
        } else {
            // Se não houver plano ativo, o status será sempre "Inativo"
            $aluno->status = 'Inativo';
        }

        $aluno->save();
    }
}
