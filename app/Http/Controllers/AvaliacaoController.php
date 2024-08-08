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
            'altura' => 'required|numeric',
            'idade' => 'required|integer',
            'peso' => 'required|numeric',
            'porcentagem_gordura' => 'required|numeric',
            'braco_direito_gordura' => 'required|numeric',
            'braco_esquerdo_gordura' => 'required|numeric',
            'perna_direita_gordura' => 'required|numeric',
            'perna_esquerda_gordura' => 'required|numeric',
            'tronco_gordura' => 'required|numeric',
            'massa_muscular' => 'required|numeric',
            'braco_direito_muscular' => 'required|numeric',
            'braco_esquerdo_muscular' => 'required|numeric',
            'perna_direita_muscular' => 'required|numeric',
            'perna_esquerda_muscular' => 'required|numeric',
            'tronco_muscular' => 'required|numeric',
            'massa_ossea' => 'required|numeric',
            'gordura_visceral' => 'required|numeric',
            'porcentagem_agua' => 'required|numeric',
            'taxa_metabolica_basal' => 'required|numeric',
            'idade_metabolica' => 'required|integer',
        ]);

        $avaliacao = new Avaliacao($request->all());
        $avaliacao->aluno_id = $alunoId; // Associa a avaliação ao aluno
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
            'altura' => 'required|numeric',
            'idade' => 'required|integer',
            'peso' => 'required|numeric',
            'porcentagem_gordura' => 'required|numeric',
            'braco_direito_gordura' => 'required|numeric',
            'braco_esquerdo_gordura' => 'required|numeric',
            'perna_direita_gordura' => 'required|numeric',
            'perna_esquerda_gordura' => 'required|numeric',
            'tronco_gordura' => 'required|numeric',
            'massa_muscular' => 'required|numeric',
            'braco_direito_muscular' => 'required|numeric',
            'braco_esquerdo_muscular' => 'required|numeric',
            'perna_direita_muscular' => 'required|numeric',
            'perna_esquerda_muscular' => 'required|numeric',
            'tronco_muscular' => 'required|numeric',
            'massa_ossea' => 'required|numeric',
            'gordura_visceral' => 'required|numeric',
            'porcentagem_agua' => 'required|numeric',
            'taxa_metabolica_basal' => 'required|numeric',
            'idade_metabolica' => 'required|integer',
        ], [
            'avaliador.required' => 'O campo avaliador é obrigatório.',
            'data.required' => 'O campo data é obrigatório.',
            'altura.required' => 'O campo altura é obrigatório.',
            'idade.required' => 'O campo idade é obrigatório.',
            'peso.required' => 'O campo peso é obrigatório.',
            'porcentagem_gordura.required' => 'O campo porcentagem de gordura é obrigatório.',
            // Adicione outras mensagens de validação conforme necessário
        ]);

        $avaliacao = Avaliacao::findOrFail($id);

        // Atualiza os dados da avaliação
        $avaliacao->avaliador = $request->input('avaliador');
        $avaliacao->data = $request->input('data');
        $avaliacao->altura = $request->input('altura');
        $avaliacao->idade = $request->input('idade');
        $avaliacao->peso = $request->input('peso');
        $avaliacao->porcentagem_gordura = $request->input('porcentagem_gordura');
        $avaliacao->braco_direito_gordura = $request->input('braco_direito_gordura');
        $avaliacao->braco_esquerdo_gordura = $request->input('braco_esquerdo_gordura');
        $avaliacao->perna_direita_gordura = $request->input('perna_direita_gordura');
        $avaliacao->perna_esquerda_gordura = $request->input('perna_esquerda_gordura');
        $avaliacao->tronco_gordura = $request->input('tronco_gordura');
        $avaliacao->massa_muscular = $request->input('massa_muscular');
        $avaliacao->braco_direito_muscular = $request->input('braco_direito_muscular');
        $avaliacao->braco_esquerdo_muscular = $request->input('braco_esquerdo_muscular');
        $avaliacao->perna_direita_muscular = $request->input('perna_direita_muscular');
        $avaliacao->perna_esquerda_muscular = $request->input('perna_esquerda_muscular');
        $avaliacao->tronco_muscular = $request->input('tronco_muscular');
        $avaliacao->massa_ossea = $request->input('massa_ossea');
        $avaliacao->gordura_visceral = $request->input('gordura_visceral');
        $avaliacao->porcentagem_agua = $request->input('porcentagem_agua');
        $avaliacao->taxa_metabolica_basal = $request->input('taxa_metabolica_basal');
        $avaliacao->idade_metabolica = $request->input('idade_metabolica');

        // Salva as alterações no banco de dados
        $avaliacao->save();

        return redirect()->route('avaliacoes.show', $avaliacao->id)->with('success', 'Avaliação atualizada com sucesso.');
    }

    public function destroy($id)
{
    $avaliacao = Avaliacao::findOrFail($id);
    $avaliacao->delete();

    return response()->json(['success' => 'Avaliação removida com sucesso.']);
}
}
