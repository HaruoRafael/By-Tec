<?php

namespace App\Http\Controllers;

use App\Models\Caixa;
use App\Models\Venda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CaixaController extends Controller
{
    /**
     * Exibe a lista de caixas (abertos e fechados).
     */
    public function index()
    {
        // Lista de caixas
        $caixas = Caixa::orderBy('data_abertura', 'desc')->get();

        return view('caixas.index', compact('caixas'));
    }

    /**
     * Exibe a página para abrir um novo caixa.
     */
    public function create()
    {
        return view('caixas.create');
    }

    /**
     * Abre um novo caixa.
     */
    public function store(Request $request)
    {
        // Verifica se já existe um caixa aberto
        $caixaAberto = Caixa::where('status', 'aberto')->exists();
        if ($caixaAberto) {
            return redirect()->route('caixas.index')->with('error', 'Já existe um caixa aberto.');
        }

        // Abre um novo caixa
        Caixa::create([
            'user_id' => Auth::id(),
            'data_abertura' => Carbon::now(),
            'saldo_inicial' => $request->input('saldo_inicial'),
            'status' => 'aberto',
        ]);

        return redirect()->route('caixas.index')->with('success', 'Caixa aberto com sucesso.');
    }

    /**
     * Mostra os detalhes de um caixa específico, incluindo vendas.
     */
    public function show(Caixa $caixa)
    {
        // Carrega todas as vendas relacionadas ao caixa
        $vendas = Venda::where('caixa_id', $caixa->id)->get();

        // Calcula o saldo total com base nas vendas
        $totalVendas = $vendas->sum('valor');

        // O saldo final será o saldo inicial + o total das vendas
        $saldoFinalCalculado = $caixa->saldo_inicial + $totalVendas;

        return view('caixas.show', compact('caixa', 'vendas', 'saldoFinalCalculado'));
    }

    /**
     * Fecha o caixa atual.
     */
    public function fechar(Request $request, Caixa $caixa)
    {
        // Verifica se o caixa está aberto
        if ($caixa->status !== 'aberto') {
            return redirect()->back()->with('error', 'Este caixa já foi fechado.');
        }

        // Fecha o caixa e atualiza o saldo final
        $caixa->update([
            'data_fechamento' => Carbon::now(),
            'saldo_final' => $request->input('saldo_final'),
            'status' => 'fechado',
        ]);

        return redirect()->route('caixas.index')->with('success', 'Caixa fechado com sucesso.');
    }
}
