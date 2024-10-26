<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venda;
use App\Models\Aluno;
use App\Models\Plano;
use App\Models\Caixa;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;  

class VendaController extends Controller
{
    public function create(Request $request)
    {
        $aluno = Aluno::find($request->input('aluno_id'));
    
        $planos = Plano::where('ativo', true)->get();
    
        $venda_atual = $aluno->vendas()->where('status', 'Ativo')->first();
    
        if ($venda_atual) {
            return redirect()->route('alunos.show', $aluno->id)
                ->with('error', 'O aluno já possui um plano ativo. Não é possível realizar outra venda.');
        }
    
        $caixaAberto = Caixa::where('status', 'aberto')->first();
    
        if (!$caixaAberto) {
            return redirect()->route('alunos.show', $aluno->id)
                ->with('error', 'Não há nenhum caixa aberto no momento. Por favor, abra um caixa para realizar a venda.');
        }
    
        return view('vendas.create', compact('aluno', 'planos'));
    }

    public function store(Request $request)
    {
        $caixa = Caixa::where('status', 'aberto')->first();

        $plano = Plano::find($request->input('plano_id'));
        $valor_original = $plano->valor;

        $desconto = $request->input('desconto', 0);
        $valor_final = $valor_original * (1 - ($desconto / 100));

        $data_inicio = Carbon::parse($request->input('data_inicio'));

        $data_expiracao = $data_inicio->copy()->addMonths($plano->duracao);

        $venda = new Venda();
        $venda->descricao = $request->input('descricao');
        $venda->data = Carbon::now();  
        $venda->valor = $valor_final;
        $venda->forma_pagamento = $request->input('forma_pagamento');
        $venda->aluno_id = $request->input('aluno_id');
        $venda->plano_id = $request->input('plano_id');
        $venda->user_id = Auth::id();
        $venda->data_inicio = $data_inicio;  
        $venda->data_expiracao = $data_expiracao;
        $venda->caixa_id = $caixa->id;  
        $venda->save();

        $this->atualizarStatusAluno($venda->aluno_id);

        return redirect()->route('alunos.show', $venda->aluno_id)->with('success', 'Venda realizada com sucesso!');
    }

    public function show($id)
    {
        $aluno = Aluno::findOrFail($id);
        $vendas = $aluno->vendas;

        foreach ($vendas as $venda) {
            if ($venda->status === 'Ativo' && Carbon::now()->greaterThan($venda->data_expiracao)) {
                $venda->status = 'Finalizado';
                $venda->save();
            }
        }

        return view('alunos.show', compact('aluno', 'vendas'));
    }

    public function finalizar($id)
    {
        $venda = Venda::findOrFail($id);

        if ($venda->status === 'Finalizado') {
            return redirect()->back()->with('error', 'Esta venda já foi finalizada.');
        }

        $venda->status = 'Finalizado';
        $venda->save();

        $this->atualizarStatusAluno($venda->aluno_id);

        return redirect()->route('alunos.show', $venda->aluno_id)->with('success', 'Venda finalizada com sucesso!');
    }
   
    private function atualizarStatusAluno($aluno_id)
    {
        $aluno = Aluno::findOrFail($aluno_id);

        $planoAtivo = $aluno->vendas()->where('status', 'Ativo')->exists();

        if ($planoAtivo) {
            $aluno->status = 'Ativo';
        } else {
            $aluno->status = 'Inativo';
        }

        $aluno->save();
    }

    public function reembolsar($id)
    {
        $venda = Venda::findOrFail($id);

        $caixa = Caixa::findOrFail($venda->caixa_id);

     
        $caixa->saldo_final -= $venda->valor;
        $caixa->save();

        $venda->status = 'Reembolsada';
        $venda->save();

        $this->atualizarStatusAluno($venda->aluno_id);

        return redirect()->route('caixas.show', $caixa->id)->with('success', 'Venda reembolsada e saldo do caixa atualizado com sucesso.');
    }

    public function showVenda($id)
    {
        $venda = Venda::with('aluno', 'plano')->findOrFail($id);

        return view('vendas.show', compact('venda'));
    }


    public function verificarExpiracao()
    {
        try {
            $vendasExpiradas = Venda::where('status', 'Ativo')
                ->whereDate('data_expiracao', '<', Carbon::now()) 
                ->get();

            if ($vendasExpiradas->isEmpty()) {
                return redirect()->back()->with('info', 'Nenhuma venda expirou.');
            }

            foreach ($vendasExpiradas as $venda) {
                $this->finalizar($venda->id); 
            }

            return redirect()->back()->with('success', 'Planos expirados foram verificados e atualizados com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao verificar as vendas expiradas.');
        }
    }

    
}