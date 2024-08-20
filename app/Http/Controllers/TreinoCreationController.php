<?php

namespace App\Http\Controllers;
use App\Models\ExercicioTreino;

use App\Models\Treino;
use App\Models\Exercicio;
use Illuminate\Http\Request;

class TreinoCreationController extends Controller
{
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
            'dia1_exercicios.*' => 'required|string',
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
                $exercicioNome = $request->input("dia{$dia}_exercicios.$i");
                $exercicio = Exercicio::where('nome', $exercicioNome)->first();

                if ($exercicio) {
                    ExercicioTreino::create([
                        'treino_id' => $treino->id,
                        'exercicio_id' => $exercicio->id,
                        'series' => $request->input("dia{$dia}_series.$i"),
                        'repeticoes' => $request->input("dia{$dia}_repeticoes.$i"),
                    ]);
                } else {
                    return redirect()->back()->withErrors(['exercicio' => "Exercício '{$exercicioNome}' não encontrado."]);
                }
            }
        }

        return redirect()->route('treinos.index');
    }
}
