<?php

namespace App\Http\Controllers;

use App\Models\Plano;
use Illuminate\Http\Request;

class PlanoController extends Controller
{
    public function index()
    {
        $planos = Plano::all();
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

    public function destroy(Plano $plano)
    {
        $plano->delete();

        return redirect()->route('planos.index')->with('success', 'Plano excluído com sucesso!');
    }
}
