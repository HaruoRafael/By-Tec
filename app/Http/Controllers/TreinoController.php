<?php

namespace App\Http\Controllers;

use App\Models\Treino;
use App\Models\Exercicio;
use App\Models\ExercicioTreino;
use Illuminate\Http\Request;

class TreinoController extends Controller
{
    public function index()
    {
        $treinos = Treino::with('exercicios')->get();
        return view('treinos.index', compact('treinos'));
    }

    public function create()
    {
        $exercicios = Exercicio::all();
        return view('treinos.create', compact('exercicios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'tipo' => 'required|in:iniciante,intermediário,avançado',
            'dia1_exercicios.*' => 'required|exists:exercicios,id',
            'dia1_series.*' => 'required|integer|min:1',
            'dia1_repeticoes.*' => 'required|integer|min:1',
            // Repita a validação para os dias 2 e 3
        ]);

        $treino = Treino::create([
            'nome' => $request->nome,
            'tipo' => $request->tipo,
            'user_id' => auth()->id(),
        ]);

        foreach (['1', '2', '3'] as $dia) {
            for ($i = 0; $i < 6; $i++) {
                ExercicioTreino::create([
                    'treino_id' => $treino->id,
                    'exercicio_id' => $request->input("dia{$dia}_exercicios.$i"),
                    'series' => $request->input("dia{$dia}_series.$i"),
                    'repeticoes' => $request->input("dia{$dia}_repeticoes.$i"),
                ]);
            }
        }

        return redirect()->route('treinos.index');
    }
    public function show(Treino $treino)
    {
        $exercicios = Exercicio::all(); // Carregando todos os exercícios
        $treino->load('exercicios'); // Carregando os exercícios relacionados ao treino
        return view('treinos.show', compact('treino', 'exercicios'));
    }

    public function edit(Treino $treino)
    {
        $exercicios = Exercicio::all();
        return view('treinos.edit', compact('treino', 'exercicios'));
    }

    public function update(Request $request, Treino $treino)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'tipo' => 'required|in:iniciante,intermediário,avançado',
            'dia1_exercicios.*' => 'required|exists:exercicios,id',
            'dia1_series.*' => 'required|integer|min:1',
            'dia1_repeticoes.*' => 'required|integer|min:1',
            // Repita a validação para os dias 2 e 3
        ]);

        $treino->update([
            'nome' => $request->nome,
            'tipo' => $request->tipo,
            'user_id' => auth()->id(),
        ]);

        ExercicioTreino::where('treino_id', $treino->id)->delete(); // Remove todas as associações atuais

        foreach (['1', '2', '3'] as $dia) {
            for ($i = 0; $i < 6; $i++) {
                ExercicioTreino::create([
                    'treino_id' => $treino->id,
                    'exercicio_id' => $request->input("dia{$dia}_exercicios.$i"),
                    'series' => $request->input("dia{$dia}_series.$i"),
                    'repeticoes' => $request->input("dia{$dia}_repeticoes.$i"),
                ]);
            }
        }

        return redirect()->route('treinos.index');
    }

    public function destroy(Treino $treino)
    {
        $treino->delete();
        return redirect()->route('treinos.index');
    }
    public function search(Request $request)
{
    $termo = $request->input('query');
    $treinos = Treino::where('nome', 'LIKE', "%{$termo}%")->pluck('nome'); // Retorna apenas os nomes dos treinos

    return response()->json($treinos);
}
}
