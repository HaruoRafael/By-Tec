<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imprimir Treino</title>
</head>
<body>
    <h1>Detalhes do Treino</h1>

    <table border="1" cellpadding="8" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Nome do Treino</th>
                <th>Exercício</th>
                <th>Séries</th>
                <th>Repetições</th>
            </tr>
        </thead>
        <tbody>
            <!-- Exibindo os exercícios do Dia 1 -->
            <tr>
                <td colspan="4" style="font-weight: bold; text-align: center;">Dia 1</td>
            </tr>
            @foreach($treino->exercicios->slice(0, 6) as $exercicio)
                <tr>
                    <td>{{ $treino->nome }}</td>
                    <td>{{ $exercicio->nome }}</td>
                    <td>{{ $exercicio->pivot->series }}</td>
                    <td>{{ $exercicio->pivot->repeticoes }}</td>
                </tr>
            @endforeach

            <!-- Exibindo os exercícios do Dia 2 -->
            <tr>
                <td colspan="4" style="font-weight: bold; text-align: center;">Dia 2</td>
            </tr>
            @foreach($treino->exercicios->slice(6, 6) as $exercicio)
                <tr>
                    <td>{{ $treino->nome }}</td>
                    <td>{{ $exercicio->nome }}</td>
                    <td>{{ $exercicio->pivot->series }}</td>
                    <td>{{ $exercicio->pivot->repeticoes }}</td>
                </tr>
            @endforeach

            <!-- Exibindo os exercícios do Dia 3 -->
            <tr>
                <td colspan="4" style="font-weight: bold; text-align: center;">Dia 3</td>
            </tr>
            @foreach($treino->exercicios->slice(12, 6) as $exercicio)
                <tr>
                    <td>{{ $treino->nome }}</td>
                    <td>{{ $exercicio->nome }}</td>
                    <td>{{ $exercicio->pivot->series }}</td>
                    <td>{{ $exercicio->pivot->repeticoes }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
