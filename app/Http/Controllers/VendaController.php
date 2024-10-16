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
        // Buscar o aluno baseado no ID fornecido
        $aluno = Aluno::find($request->input('aluno_id'));
    
        // Listar apenas planos ativos
        $planos = Plano::where('ativo', true)->get();
    
        // Verifica se o aluno já tem um plano ativo
        $venda_atual = $aluno->vendas()->where('status', 'Ativo')->first();
    
        if ($venda_atual) {
            // Se o aluno tiver um plano ativo, redireciona com uma mensagem de erro
            return redirect()->route('alunos.show', $aluno->id)
                ->with('error', 'O aluno já possui um plano ativo. Não é possível realizar outra venda.');
        }
    
        // Verifica se existe um caixa aberto
        $caixaAberto = Caixa::where('status', 'aberto')->first();
    
        if (!$caixaAberto) {
            // Se não houver caixa aberto, redireciona com mensagem de erro
            return redirect()->route('alunos.show', $aluno->id)
                ->with('error', 'Não há nenhum caixa aberto no momento. Por favor, abra um caixa para realizar a venda.');
        }
    
        // Se tudo estiver correto, exibe o formulário de venda
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

        // Recupera a data de início selecionada no formulário
        $data_inicio = Carbon::parse($request->input('data_inicio'));

        // Calcula a data de expiração com base na duração do plano
        $data_expiracao = $data_inicio->copy()->addMonths($plano->duracao);

        // Cria a venda e associa o usuário logado e o caixa aberto
        $venda = new Venda();
        $venda->descricao = $request->input('descricao');
        $venda->data = Carbon::now();  // Data da venda
        $venda->valor = $valor_final;
        $venda->forma_pagamento = $request->input('forma_pagamento');
        $venda->aluno_id = $request->input('aluno_id');
        $venda->plano_id = $request->input('plano_id');
        $venda->user_id = Auth::id();
        $venda->data_inicio = $data_inicio;  // Data de início do plano
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
        $vendas = $aluno->vendas;

        foreach ($vendas as $venda) {
            // Verifica se o plano expirou
            if ($venda->status === 'Ativo' && Carbon::now()->greaterThan($venda->data_expiracao)) {
                // Se expirou, atualiza o status para "Finalizado"
                $venda->status = 'Finalizado';
                $venda->save();
            }
        }

        return view('alunos.show', compact('aluno', 'vendas'));
    }

    public function finalizar($id)
    {
        // Recupera a venda que será finalizada
        $venda = Venda::findOrFail($id);

        // Verifica se a venda já está finalizada
        if ($venda->status === 'Finalizado') {
            return redirect()->back()->with('error', 'Esta venda já foi finalizada.');
        }

        // Atualiza o status da venda para "Finalizado"
        $venda->status = 'Finalizado';
        $venda->save();

        // Atualiza o status do aluno para verificar se ele tem algum plano ativo
        $this->atualizarStatusAluno($venda->aluno_id);

        // Redireciona com uma mensagem de sucesso
        return redirect()->route('alunos.show', $venda->aluno_id)->with('success', 'Venda finalizada com sucesso!');
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
        $caixa->saldo_final -= $venda->valor;

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

    public function reembolsar($id)
    {
        // Recupera a venda que será reembolsada
        $venda = Venda::findOrFail($id);


        // Recupera o caixa relacionado à venda
        $caixa = Caixa::findOrFail($venda->caixa_id);

        // Verifica se o caixa está aberto
        if ($caixa->status !== 'aberto') {
            return redirect()->back()->with('error', 'O caixa já está fechado.');
        }

        // Atualiza o saldo do caixa subtraindo o valor da venda reembolsada
        $caixa->saldo_final -= $venda->valor;
        $caixa->save();

        // Marca a venda como "Reembolsada"
        $venda->status = 'Reembolsada';
        $venda->save();

        // Atualiza o status do aluno
        $this->atualizarStatusAluno($venda->aluno_id);

        return redirect()->route('caixas.show', $caixa->id)->with('success', 'Venda reembolsada e saldo do caixa atualizado com sucesso.');
    }

    public function showVenda($id)
    {
        // Recupera a venda pelo ID
        $venda = Venda::with('aluno', 'plano')->findOrFail($id);

        // Retorna a view com os detalhes da venda
        return view('vendas.show', compact('venda'));
    }


    public function verificarExpiracao()
    {
        try {
            // Buscar apenas vendas ativas cuja data de expiração já passou
            $vendasExpiradas = Venda::where('status', 'Ativo')
                ->whereDate('data_expiracao', '<', Carbon::now()) // Verifica se já expirou
                ->get();

            // Se não houver vendas expiradas, retorna uma mensagem informativa
            if ($vendasExpiradas->isEmpty()) {
                return redirect()->back()->with('info', 'Nenhuma venda expirou.');
            }

            // Para cada venda expirada, chamamos a função finalizar
            foreach ($vendasExpiradas as $venda) {
                $this->finalizar($venda->id); // Chama a função finalizar
            }

            // Retorna mensagem de sucesso
            return redirect()->back()->with('success', 'Planos expirados foram verificados e atualizados com sucesso.');
        } catch (\Exception $e) {
            // Captura erros e redireciona com mensagem de erro
            return redirect()->back()->with('error', 'Erro ao verificar as vendas expiradas.');
        }
    }

    
}