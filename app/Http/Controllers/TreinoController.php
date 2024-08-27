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
            'dia2_exercicios.*' => 'required|exists:exercicios,id',
            'dia2_series.*' => 'required|integer|min:1',
            'dia2_repeticoes.*' => 'required|integer|min:1',
            'dia3_exercicios.*' => 'required|exists:exercicios,id',
            'dia3_series.*' => 'required|integer|min:1',
            'dia3_repeticoes.*' => 'required|integer|min:1',
        ], [
            'nome.required' => 'O nome do treino é obrigatório.',
            'tipo.required' => 'O tipo do treino é obrigatório.',
            'tipo.in' => 'O tipo do treino deve ser um dos seguintes: iniciante, intermediário, avançado.',

            // Mensagens para o Dia 1
            'dia1_exercicios.*.required' => 'O exercício do dia 1 é obrigatório.',
            'dia1_exercicios.*.exists' => 'O exercício selecionado para o dia 1 é inválido.',
            'dia1_series.*.required' => 'O número de séries para o dia 1 é obrigatório.',
            'dia1_series.*.integer' => 'O número de séries para o dia 1 deve ser um número inteiro.',
            'dia1_series.*.min' => 'O número de séries para o dia 1 deve ser pelo menos 1.',
            'dia1_repeticoes.*.required' => 'O número de repetições para o dia 1 é obrigatório.',
            'dia1_repeticoes.*.integer' => 'O número de repetições para o dia 1 deve ser um número inteiro.',
            'dia1_repeticoes.*.min' => 'O número de repetições para o dia 1 deve ser pelo menos 1.',

            // Mensagens para o Dia 2
            'dia2_exercicios.*.required' => 'O exercício do dia 2 é obrigatório.',
            'dia2_exercicios.*.exists' => 'O exercício selecionado para o dia 2 é inválido.',
            'dia2_series.*.required' => 'O número de séries para o dia 2 é obrigatório.',
            'dia2_series.*.integer' => 'O número de séries para o dia 2 deve ser um número inteiro.',
            'dia2_series.*.min' => 'O número de séries para o dia 2 deve ser pelo menos 1.',
            'dia2_repeticoes.*.required' => 'O número de repetições para o dia 2 é obrigatório.',
            'dia2_repeticoes.*.integer' => 'O número de repetições para o dia 2 deve ser um número inteiro.',
            'dia2_repeticoes.*.min' => 'O número de repetições para o dia 2 deve ser pelo menos 1.',

            // Mensagens para o Dia 3
            'dia3_exercicios.*.required' => 'O exercício do dia 3 é obrigatório.',
            'dia3_exercicios.*.exists' => 'O exercício selecionado para o dia 3 é inválido.',
            'dia3_series.*.required' => 'O número de séries para o dia 3 é obrigatório.',
            'dia3_series.*.integer' => 'O número de séries para o dia 3 deve ser um número inteiro.',
            'dia3_series.*.min' => 'O número de séries para o dia 3 deve ser pelo menos 1.',
            'dia3_repeticoes.*.required' => 'O número de repetições para o dia 3 é obrigatório.',
            'dia3_repeticoes.*.integer' => 'O número de repetições para o dia 3 deve ser um número inteiro.',
            'dia3_repeticoes.*.min' => 'O número de repetições para o dia 3 deve ser pelo menos 1.',
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
            'dia2_exercicios.*' => 'required|exists:exercicios,id',
            'dia2_series.*' => 'required|integer|min:1',
            'dia2_repeticoes.*' => 'required|integer|min:1',
            'dia3_exercicios.*' => 'required|exists:exercicios,id',
            'dia3_series.*' => 'required|integer|min:1',
            'dia3_repeticoes.*' => 'required|integer|min:1',
        ], [
            'nome.required' => 'O nome do treino é obrigatório.',
            'tipo.required' => 'O tipo do treino é obrigatório.',
            'tipo.in' => 'O tipo do treino deve ser um dos seguintes: iniciante, intermediário, avançado.',

            // Mensagens para o Dia 1
            'dia1_exercicios.*.required' => 'O exercício do dia 1 é obrigatório.',
            'dia1_exercicios.*.exists' => 'O exercício selecionado para o dia 1 é inválido.',
            'dia1_series.*.required' => 'O número de séries para o dia 1 é obrigatório.',
            'dia1_series.*.integer' => 'O número de séries para o dia 1 deve ser um número inteiro.',
            'dia1_series.*.min' => 'O número de séries para o dia 1 deve ser pelo menos 1.',
            'dia1_repeticoes.*.required' => 'O número de repetições para o dia 1 é obrigatório.',
            'dia1_repeticoes.*.integer' => 'O número de repetições para o dia 1 deve ser um número inteiro.',
            'dia1_repeticoes.*.min' => 'O número de repetições para o dia 1 deve ser pelo menos 1.',

            // Mensagens para o Dia 2
            'dia2_exercicios.*.required' => 'O exercício do dia 2 é obrigatório.',
            'dia2_exercicios.*.exists' => 'O exercício selecionado para o dia 2 é inválido.',
            'dia2_series.*.required' => 'O número de séries para o dia 2 é obrigatório.',
            'dia2_series.*.integer' => 'O número de séries para o dia 2 deve ser um número inteiro.',
            'dia2_series.*.min' => 'O número de séries para o dia 2 deve ser pelo menos 1.',
            'dia2_repeticoes.*.required' => 'O número de repetições para o dia 2 é obrigatório.',
            'dia2_repeticoes.*.integer' => 'O número de repetições para o dia 2 deve ser um número inteiro.',
            'dia2_repeticoes.*.min' => 'O número de repetições para o dia 2 deve ser pelo menos 1.',

            // Mensagens para o Dia 3
            'dia3_exercicios.*.required' => 'O exercício do dia 3 é obrigatório.',
            'dia3_exercicios.*.exists' => 'O exercício selecionado para o dia 3 é inválido.',
            'dia3_series.*.required' => 'O número de séries para o dia 3 é obrigatório.',
            'dia3_series.*.integer' => 'O número de séries para o dia 3 deve ser um número inteiro.',
            'dia3_series.*.min' => 'O número de séries para o dia 3 deve ser pelo menos 1.',
            'dia3_repeticoes.*.required' => 'O número de repetições para o dia 3 é obrigatório.',
            'dia3_repeticoes.*.integer' => 'O número de repetições para o dia 3 deve ser um número inteiro.',
            'dia3_repeticoes.*.min' => 'O número de repetições para o dia 3 deve ser pelo menos 1.',
        ]);

        $treino->update(['nome' => $request->nome,'tipo' => $request->tipo,'user_id' => auth()->id()
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

        return redirect()->route('treinos.show', $treino->id);
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
