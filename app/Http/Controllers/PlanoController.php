<?php

namespace App\Http\Controllers;

use App\Models\Plano;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlanoController extends Controller
{
    public function index(Request $request)
    {
        // Inicia a consulta no modelo Plano
        $query = Plano::query();

        // Filtro por nome (termo de pesquisa)
        if ($request->has('termo')) {
            $termo = strtolower($request->input('termo'));
            $query->where(DB::raw('LOWER(nome)'), 'LIKE', "%{$termo}%");
        }

        
        // Filtro por duração
        if ($request->has('duracao')) {
            $duracao = $request->input('duracao');
            $query->where('duracao', '=', $duracao);
        }

        // Filtro por status ativo/inativo


        // Paginação de 10 planos por página
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
            'nome' => 'required|string|max:255',
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
            'nome' => 'required|string|max:255',
            'valor' => 'required|numeric|min:0',
            'duracao' => 'required|integer|min:1',
        ]);

        $plano->update($request->all());

        return redirect()->route('planos.index')->with('success', 'Plano atualizado com sucesso!');
    }

    public function remove($id)
    {
        $plano = Plano::findOrFail($id);
        // Aqui, em vez de "Removido", usamos 'ativo' como false
        $plano->ativo = false;
        $plano->save();

        return redirect()->route('planos.index')->with('success', 'Plano ocultado com sucesso.');
    }

    public function reativar($id)
    {
        $plano = Plano::findOrFail($id);
        // Atualizamos o status 'ativo' para true
        $plano->ativo = true;
        $plano->save();

        return redirect()->route('planos.index')->with('success', 'Plano reativado com sucesso.');
    }
}
