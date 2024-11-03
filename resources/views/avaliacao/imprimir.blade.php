<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imprimir Avaliação</title>
</head>
<body>
    <h1>Detalhes da Avaliação</h1>

    <table border="1" cellpadding="8" cellspacing="0" width="100%">
        <tr>
            <th>Aluno</th>
            <td>{{ $avaliacao->aluno->nome }}</td>
        </tr>
        <tr>
            <th>Avaliador</th>
            <td>{{ $avaliacao->avaliador }}</td>
        </tr>
        <tr>
            <th>Data</th>
            <td>{{ \Carbon\Carbon::parse($avaliacao->data)->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <th>Altura</th>
            <td>{{ $avaliacao->altura }}</td>
        </tr>
        <tr>
            <th>Idade</th>
            <td>{{ $avaliacao->idade }}</td>
        </tr>
        <tr>
            <th>Peso</th>
            <td>{{ $avaliacao->peso }}</td>
        </tr>
        <tr>
            <th>% Gordura</th>
            <td>{{ $avaliacao->porcentagem_gordura }}</td>
        </tr>
        <!-- Parte Gordura -->
        <tr><th colspan="2" style="text-align: center; font-weight: bold;">Parte Gordura</th></tr>
        <tr><th>Braço Direito</th><td>{{ $avaliacao->braco_direito_gordura }}</td></tr>
        <tr><th>Braço Esquerdo</th><td>{{ $avaliacao->braco_esquerdo_gordura }}</td></tr>
        <tr><th>Perna Direita</th><td>{{ $avaliacao->perna_direita_gordura }}</td></tr>
        <tr><th>Perna Esquerda</th><td>{{ $avaliacao->perna_esquerda_gordura }}</td></tr>
        <tr><th>Tronco</th><td>{{ $avaliacao->tronco_gordura }}</td></tr>
        
        <!-- Parte Massa Muscular -->
        <tr><th colspan="2" style="text-align: center; font-weight: bold;">Parte Massa Muscular</th></tr>
        <tr><th>Massa Muscular</th><td>{{ $avaliacao->massa_muscular }}</td></tr>
        <tr><th>Braço Direito</th><td>{{ $avaliacao->braco_direito_muscular }}</td></tr>
        <tr><th>Braço Esquerdo</th><td>{{ $avaliacao->braco_esquerdo_muscular }}</td></tr>
        <tr><th>Perna Direita</th><td>{{ $avaliacao->perna_direita_muscular }}</td></tr>
        <tr><th>Perna Esquerda</th><td>{{ $avaliacao->perna_esquerda_muscular }}</td></tr>
        <tr><th>Tronco</th><td>{{ $avaliacao->tronco_muscular }}</td></tr>
        
        <!-- Escala Constituição -->
        <tr><th colspan="2" style="text-align: center; font-weight: bold;">Escala Constituição</th></tr>
        <tr><th>Massa Óssea</th><td>{{ $avaliacao->massa_ossea }}</td></tr>
        <tr><th>Gordura Visceral</th><td>{{ $avaliacao->gordura_visceral }}</td></tr>
        <tr><th>% Água</th><td>{{ $avaliacao->porcentagem_agua }}</td></tr>
        <tr><th>Taxa Metabólica Basal</th><td>{{ $avaliacao->taxa_metabolica_basal }}</td></tr>
        <tr><th>Idade Metabólica</th><td>{{ $avaliacao->idade_metabolica }}</td></tr>
    </table>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
