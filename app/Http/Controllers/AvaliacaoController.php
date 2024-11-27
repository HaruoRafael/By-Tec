<?php

namespace App\Http\Controllers;

use App\Models\Avaliacao;
use App\Models\Aluno;
use Illuminate\Http\Request;

class AvaliacaoController extends Controller
{
    public function index()
    {
        $avaliacoes = Avaliacao::all();
        return view('avaliacao.index', compact('avaliacoes'));
    }

    public function create($alunoId)
    {
        $aluno = Aluno::findOrFail($alunoId);
        return view('avaliacao.create', compact('aluno'));
    }

    public function store(Request $request, $alunoId)
    {
        $request->validate([
            'avaliador' => 'required|string|max:255',
            'data' => 'required|date',
            'altura' => 'required|numeric|between:0,3',
            'idade' => 'required|integer|min:1|max:120',
            'peso' => 'required|numeric|min:1|max:300',
            'porcentagem_gordura' => 'required|numeric|between:0,100',
            'braco_direito_gordura' => 'required|numeric|between:0,100',
            'braco_esquerdo_gordura' => 'required|numeric|between:0,100',
            'perna_direita_gordura' => 'required|numeric|between:0,100',
            'perna_esquerda_gordura' => 'required|numeric|between:0,100',
            'tronco_gordura' => 'required|numeric|between:0,100',
            'massa_muscular' => 'required|numeric|min:1|max:200',
            'braco_direito_muscular' => 'required|numeric|min:1|max:100',
            'braco_esquerdo_muscular' => 'required|numeric|min:1|max:100',
            'perna_direita_muscular' => 'required|numeric|min:1|max:100',
            'perna_esquerda_muscular' => 'required|numeric|min:1|max:100',
            'tronco_muscular' => 'required|numeric|min:1|max:200',
            'massa_ossea' => 'required|numeric|min:1|max:100',
            'gordura_visceral' => 'required|numeric|min:1|max:30',
            'porcentagem_agua' => 'required|numeric|between:0,100',
            'taxa_metabolica_basal' => 'required|numeric|min:500|max:5000',
            'idade_metabolica' => 'required|integer|min:1|max:120',
        ], [
            'required' => 'O campo :attribute é obrigatório.',
            'numeric' => 'O campo :attribute deve ser um número válido.',
            'integer' => 'O campo :attribute deve ser um número inteiro.',
            'between' => 'O campo :attribute deve estar entre :min e :max.',
            'min' => 'O campo :attribute deve ser pelo menos :min.',
            'max' => 'O campo :attribute não pode ser maior que :max.',
        ]);

        $data = $request->all();

        $camposNumericos = [
            'altura',
            'peso',
            'porcentagem_gordura',
            'braco_direito_gordura',
            'braco_esquerdo_gordura',
            'perna_direita_gordura',
            'perna_esquerda_gordura',
            'tronco_gordura',
            'massa_muscular',
            'braco_direito_muscular',
            'braco_esquerdo_muscular',
            'perna_direita_muscular',
            'perna_esquerda_muscular',
            'tronco_muscular',
            'massa_ossea',
            'gordura_visceral',
            'porcentagem_agua',
            'taxa_metabolica_basal'
        ];

        foreach ($camposNumericos as $campo) {
            if (isset($data[$campo])) {
                $data[$campo] = number_format((float) $data[$campo], 2, '.', '');
            }
        }

        $avaliacao = new Avaliacao($request->all());
        $avaliacao->aluno_id = $alunoId;
        $avaliacao->save();

        return redirect()->route('alunos.show', $alunoId)->with('success', 'Avaliação criada com sucesso!');
    }

    public function show($id)
    {
        $avaliacao = Avaliacao::findOrFail($id);
        return view('avaliacao.show', compact('avaliacao'));
    }

    public function edit(Avaliacao $avaliacao)
    {
        return view('avaliacao.edit', compact('avaliacao'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'avaliador' => 'required|string|max:255',
            'data' => 'required|date',
            'altura' => 'required|numeric|between:0,3',
            'idade' => 'required|integer|min:1|max:120',
            'peso' => 'required|numeric|min:1|max:300',
            'porcentagem_gordura' => 'required|numeric|between:0,100',
            'braco_direito_gordura' => 'required|numeric|between:0,100',
            'braco_esquerdo_gordura' => 'required|numeric|between:0,100',
            'perna_direita_gordura' => 'required|numeric|between:0,100',
            'perna_esquerda_gordura' => 'required|numeric|between:0,100',
            'tronco_gordura' => 'required|numeric|between:0,100',
            'massa_muscular' => 'required|numeric|min:1|max:200',
            'braco_direito_muscular' => 'required|numeric|min:1|max:100',
            'braco_esquerdo_muscular' => 'required|numeric|min:1|max:100',
            'perna_direita_muscular' => 'required|numeric|min:1|max:100',
            'perna_esquerda_muscular' => 'required|numeric|min:1|max:100',
            'tronco_muscular' => 'required|numeric|min:1|max:200',
            'massa_ossea' => 'required|numeric|min:1|max:100',
            'gordura_visceral' => 'required|numeric|min:1|max:30',
            'porcentagem_agua' => 'required|numeric|between:0,100',
            'taxa_metabolica_basal' => 'required|numeric|min:500|max:5000',
            'idade_metabolica' => 'required|integer|min:1|max:120',
        ], [
            'required' => 'O campo :attribute é obrigatório.',
            'numeric' => 'O campo :attribute deve ser um número válido.',
            'integer' => 'O campo :attribute deve ser um número inteiro.',
            'between' => 'O campo :attribute deve estar entre :min e :max.',
            'min' => 'O campo :attribute deve ser pelo menos :min.',
            'max' => 'O campo :attribute não pode ser maior que :max.',
        ]);

        $avaliacao = Avaliacao::findOrFail($id);
        $data = $request->all();

        $camposNumericos = [
            'altura', 'peso', 'porcentagem_gordura', 'braco_direito_gordura', 'braco_esquerdo_gordura',
            'perna_direita_gordura', 'perna_esquerda_gordura', 'tronco_gordura', 'massa_muscular',
            'braco_direito_muscular', 'braco_esquerdo_muscular', 'perna_direita_muscular', 'perna_esquerda_muscular',
            'tronco_muscular', 'massa_ossea', 'gordura_visceral', 'porcentagem_agua', 'taxa_metabolica_basal'
        ];
    
        foreach ($camposNumericos as $campo) {
            if (isset($data[$campo])) {
                $data[$campo] = number_format((float) $data[$campo], 2, '.', '');
            }
        }
        $avaliacao->update($data);


        return redirect()->route('avaliacoes.show', $avaliacao->id)->with('success', 'Avaliação atualizada com sucesso.');
    }

    public function destroy($id)
    {
        $avaliacao = Avaliacao::findOrFail($id);
        $avaliacao->delete();

        return response()->json(['success' => 'Avaliação removida com sucesso.']);
    }

    public function imprimir($id)
    {
        $avaliacao = Avaliacao::with('aluno')->findOrFail($id);
        return view('avaliacao.imprimir', compact('avaliacao'));
    }
}
