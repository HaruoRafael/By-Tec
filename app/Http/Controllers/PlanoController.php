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

        if ($request->has('termo')) {
            $termo = strtolower($request->input('termo'));
            $query->where(DB::raw('LOWER(nome)'), 'LIKE', "%{$termo}%");
        }

        
        if ($request->has('duracao')) {
            $duracao = $request->input('duracao');
            $query->where('duracao', '=', $duracao);
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
