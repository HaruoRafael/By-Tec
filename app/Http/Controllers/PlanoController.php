<?php

namespace App\Http\Controllers;

use App\Models\Plano;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlanoController extends Controller
{
    public function index(Request $request)
    {
        $query = Plano::query();

        // Pesquisa por nome (com suporte a acentos)
        if ($request->filled('termo')) { // Verifica se o termo não é vazio ou null
            $termo = strtolower($request->input('termo'));
            $query->whereRaw("unaccent(LOWER(nome)) LIKE unaccent(?)", ["%{$termo}%"]);
        }

        // Filtro por valor máximo
        if ($request->filled('valor')) {
            $valor = $request->input('valor');
            if (is_numeric($valor)) {
                $query->where('valor', '<=', floatval($valor));
            } else {
                return redirect()->back()->withErrors(['valor' => 'O valor deve ser numérico.']);
            }
        }
        // Filtro por duração
        if ($request->filled('duracao')) { // Verifica se a duração não é vazia ou null
            $duracao = $request->input('duracao');
            if (is_numeric($duracao)) { // Verifica se é numérico antes de aplicar o filtro
                $query->where('duracao', '=', intval($duracao)); // Converte para inteiro
            } else {
                return redirect()->back()->withErrors(['duracao' => 'A duração deve ser um número válido.']);
            }
        }

        $planos = $query->orderBy('nome')->paginate(10);

        return view('planos.index', compact('planos'));
    }
    public function create()
    {
        return view('planos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:25',
            'valor' => 'required|numeric|min:0',
            'duracao' => 'required|integer|min:1',
        ]);

        Plano::create($request->all());

        return redirect()->route('planos.index')->with('success', 'Plano criado com sucesso!');
    }

    public function show(Plano $plano)
    {
        return view('planos.show', compact('plano'));
    }

    public function update(Request $request, Plano $plano)
    {
        $request->validate([
            'nome' => 'required|string|max:25',
            'valor' => 'required|numeric|min:0',
            'duracao' => 'required|integer|min:1',
        ]);

        $plano->update($request->all());

        return redirect()->route('planos.index')->with('success', 'Plano atualizado com sucesso!');
    }

    public function remove($id)
    {
        $plano = Plano::findOrFail($id);
        $plano->ativo = false;
        $plano->save();

        return redirect()->route('planos.index')->with('success', 'Plano ocultado com sucesso.');
    }

    public function reativar($id)
    {
        $plano = Plano::findOrFail($id);
        $plano->ativo = true;
        $plano->save();

        return redirect()->route('planos.index')->with('success', 'Plano reativado com sucesso.');
    }
}
