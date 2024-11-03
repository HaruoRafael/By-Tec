<?php

namespace App\Http\Controllers;

use App\Models\Caixa;
use App\Models\Venda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CaixaController extends Controller
{

    public function index(Request $request)
    {
        $dataInicio = $request->input('data_inicio');
        $dataFim = $request->input('data_fim');

        $query = Caixa::orderBy('data_abertura', 'desc');

        if ($dataInicio && $dataFim) {
            $query->whereBetween('data_abertura', [
                Carbon::parse($dataInicio)->startOfDay(),
                Carbon::parse($dataFim)->endOfDay(),
            ]);
        } elseif ($dataInicio) {
            $query->where('data_abertura', '>=', Carbon::parse($dataInicio)->startOfDay());
        } elseif ($dataFim) {
            $query->where('data_abertura', '<=', Carbon::parse($dataFim)->endOfDay());
        }

        $caixas = $query->get();

        return view('caixas.index', compact('caixas', 'dataInicio', 'dataFim'));
    }


    public function create()
    {
        return view('caixas.create');
    }


    public function store(Request $request)
    {
        $caixaAberto = Caixa::where('status', 'aberto')->exists();
        if ($caixaAberto) {
            return redirect()->route('caixas.index')->with('error', 'Já existe um caixa aberto.');
        }

        Caixa::create([
            'user_id' => Auth::id(),
            'data_abertura' => Carbon::now(),
            'saldo_inicial' => $request->input('saldo_inicial'),
            'status' => 'aberto',
        ]);

        return redirect()->route('caixas.index')->with('success', 'Caixa aberto com sucesso.');
    }

    public function show(Caixa $caixa)
    {
        $vendas = Venda::where('caixa_id', $caixa->id)->get();

        $totalVendas = $vendas->sum('valor');

        $saldoFinalCalculado = $caixa->saldo_inicial + $totalVendas;

        return view('caixas.show', compact('caixa', 'vendas', 'saldoFinalCalculado'));
    }


    public function fechar(Request $request, Caixa $caixa)
    {
        if ($caixa->status !== 'aberto') {
            return redirect()->back()->with('error', 'Este caixa já foi fechado.');
        }

        $caixa->update([
            'data_fechamento' => Carbon::now(),
            'saldo_final' => $request->input('saldo_final'),
            'status' => 'fechado',
        ]);

        return redirect()->route('caixas.index')->with('success', 'Caixa fechado com sucesso.');
    }

    public function imprimir($id)
    {
        $caixa = Caixa::with('vendas')->findOrFail($id);
        $vendas = $caixa->vendas; // Obter vendas relacionadas ao caixa
        return view('caixas.imprimir', compact('caixa', 'vendas'));
    }
}
