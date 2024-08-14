<!-- resources/views/alunos/index.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Alunos</title>
    <link href="{{ asset('css/alunos.css') }}" rel="stylesheet">
</head>
<body>
    <header>
        <h1>Lista de Alunos</h1>
        <nav>
            <ul>
                @include('components.navbar')
            </ul>
        </nav>
    </header>

    <div class="container">
        <h2>Buscar Aluno</h2>
        <form id="formPesquisaAluno" method="GET" action="{{ route('alunos.index') }}">
            <input type="text" id="termoPesquisa" name="termo" placeholder="Pesquisar aluno" value="{{ Request::input('termo') }}">
            <button type="submit">Pesquisar</button>
            @if (Request::has('termo'))
                <a href="{{ route('alunos.index') }}" class="limpar-pesquisa">Limpar Pesquisa</a>
            @endif
        </form>

        <!-- Verifica se existem resultados da pesquisa -->
        @if(isset($alunos) && count($alunos) > 0)
            <div id="listaAlunosContainer">
                <h2>Lista de Alunos</h2>
                <ul>
                    @foreach($alunos as $aluno)
                        <div class="aluno">
                            <a href="{{ route('alunos.show', $aluno->id) }}">
                                <div class="aluno-info">
                                    <p>Nome: {{ $aluno->nome }}</p>
                                    <p>Idade: {{ $aluno->idade }}</p> <!-- Substitua 'idade' pelo atributo correto -->
                                    <p>Sexo: {{ $aluno->sexo }}</p>
                                    <p>Status: {{ $aluno->status }}</p> <!-- Exibe o status do aluno -->
                                </div>
                            </a>
                        </div>
                    @endforeach
                </ul>
            </div>
        @else
            <p>Nenhum aluno encontrado.</p>
        @endif
    </div>

</body>
</html>
