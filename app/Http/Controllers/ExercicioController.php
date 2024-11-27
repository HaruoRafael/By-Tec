<?php

namespace App\Http\Controllers;

use App\Models\Exercicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExercicioController extends Controller
{
    public function index(Request $request)
    {
        $query = Exercicio::query();

        if ($request->has('termo')) {
            $termo = strtolower($request->input('termo'));
            $query->whereRaw("unaccent(LOWER(nome)) LIKE unaccent(?)", ["%{$termo}%"]);
        }
    
        // Pesquisa por grupo muscular
        if ($request->has('grupo_muscular')) {
            $grupo_muscular = strtolower($request->input('grupo_muscular'));
            $query->whereRaw("unaccent(LOWER(grupo_muscular)) LIKE unaccent(?)", ["%{$grupo_muscular}%"]);
        }

        if ($request->has('dificuldade')) {
            $dificuldade = $request->input('dificuldade');
            $query->whereIn('dificuldade', $dificuldade);
        }

        $exercicios = $query->orderBy('nome')->paginate(10);

        return view('exercicios.index', compact('exercicios'));
    }

    public function create()
    {
        return view('exercicios.create');
    }

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

    public function show(Exercicio $exercicio)
    {
        return view('exercicios.show', compact('exercicio'));
    }

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

        return redirect()->route('exercicios.show', $exercicio->id)->with('success', 'Exercício atualizado com sucesso!');
    }

    public function destroy(Exercicio $exercicio)
    {
        $exercicio->delete();

        return redirect()->route('exercicios.index')->with('success', 'Exercício excluído com sucesso!');
    }

    private function sanitizeInput($input)
    {
        $sanitized = preg_replace('/^[´`^~¨]|[^a-zA-ZÀ-ÿ\s]/', '', $input);
        return trim($sanitized);
    }
    
}
