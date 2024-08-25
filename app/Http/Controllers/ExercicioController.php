<?php

namespace App\Http\Controllers;

use App\Models\Exercicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExercicioController extends Controller
{
    // Exibir a lista de exercícios
    public function index(Request $request)
    {
        $query = Exercicio::query();

        if ($request->has('termo')) {
            $termo = strtolower($request->input('termo'));
            $query->where(DB::raw('LOWER(nome)'), 'LIKE', "%{$termo}%");
        }

        if ($request->has('grupo_muscular')) {
            $grupo_muscular = strtolower($request->input('grupo_muscular'));
            $query->where(DB::raw('LOWER(grupo_muscular)'), 'LIKE', "%{$grupo_muscular}%");
        }

        if ($request->has('dificuldade')) {
            $dificuldade = $request->input('dificuldade');
            $query->whereIn('dificuldade', $dificuldade);
        }

        $exercicios = $query->orderBy('nome')->get();

        return view('exercicios.index', compact('exercicios'));
    }

    // Mostrar o formulário para criar um novo exercício
    public function create()
    {
        return view('exercicios.create');
    }

    // Armazenar um novo exercício
    public function store(Request $request)
{
    $request->validate([
        'nome' => 'required|string|max:255',
        'grupo_muscular' => 'required|string|max:255',
        'dificuldade' => 'required|in:easy,normal,hard',
        'observacoes' => 'nullable|string',
    ], [
        'nome.required' => 'O campo nome é obrigatório.',
        'nome.string' => 'O campo nome deve ser um texto válido.',
        'nome.max' => 'O campo nome não pode ter mais que 255 caracteres.',
        'grupo_muscular.required' => 'O campo grupo muscular é obrigatório.',
        'grupo_muscular.string' => 'O campo grupo muscular deve ser um texto válido.',
        'grupo_muscular.max' => 'O campo grupo muscular não pode ter mais que 255 caracteres.',
        'dificuldade.required' => 'O campo dificuldade é obrigatório.',
        'dificuldade.in' => 'A dificuldade deve ser uma das seguintes opções: easy, normal, hard.',
        'observacoes.string' => 'O campo observações deve ser um texto válido.',
    ]);

    Exercicio::create($request->all());

    return redirect()->route('exercicios.index')->with('success', 'Exercício criado com sucesso!');
}

    // Exibir um exercício específico
    public function show(Exercicio $exercicio)
    {
        return view('exercicios.show', compact('exercicio'));
    }

    // Mostrar o formulário para editar um exercício
    public function edit(Exercicio $exercicio)
    {
        return view('exercicios.edit', compact('exercicio'));
    }

    // Atualizar um exercício
    public function update(Request $request, Exercicio $exercicio)
{
    $request->validate([
        'nome' => 'required|string|max:255',
        'grupo_muscular' => 'required|string|max:255',
        'dificuldade' => 'required|in:easy,normal,hard',
        'observacoes' => 'nullable|string',
    ], [
        'nome.required' => 'O campo nome é obrigatório.',
        'nome.string' => 'O campo nome deve ser um texto válido.',
        'nome.max' => 'O campo nome não pode ter mais que 255 caracteres.',
        'grupo_muscular.required' => 'O campo grupo muscular é obrigatório.',
        'grupo_muscular.string' => 'O campo grupo muscular deve ser um texto válido.',
        'grupo_muscular.max' => 'O campo grupo muscular não pode ter mais que 255 caracteres.',
        'dificuldade.required' => 'O campo dificuldade é obrigatório.',
        'dificuldade.in' => 'A dificuldade deve ser uma das seguintes opções: easy, normal, hard.',
        'observacoes.string' => 'O campo observações deve ser um texto válido.',
    ]);

    $exercicio->update($request->all());

    return redirect()->route('exercicios.index')->with('success', 'Exercício atualizado com sucesso!');
}

    // Excluir um exercício
    public function destroy(Exercicio $exercicio)
    {
        $exercicio->delete();

        return redirect()->route('exercicios.index')->with('success', 'Exercício excluído com sucesso!');
    }
}
