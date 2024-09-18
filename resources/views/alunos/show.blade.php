<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-yellow-500 dark:text-yellow-500 leading-tight">
            {{ __('Perfil do Aluno: ') }} {{ $aluno->nome }} <p>Status do Aluno: <strong>{{ $aluno->status }}</strong></p>

        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-4">
                <a href="{{ route('vendas.create', ['aluno_id' => $aluno->id]) }}" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700">
                    Realizar Venda para {{ $aluno->nome }}
                </a>
            </div>

            @if(session('error'))
            <div class="bg-red-500 text-white p-4 rounded-md mb-4">
                {{ session('error') }}
            </div>
            @endif

            <!-- Navegação das Abas -->
            <nav class="flex mb-4">
                <button id="btnInfo" class="px-3 py-2 text-yellow-500 hover:text-yellow-400 focus:outline-none">Informações</button>
                <button id="btnAvaliacoes" class="px-3 py-2 text-yellow-500 hover:text-yellow-400 focus:outline-none">Avaliações</button>
                <button id="btnTreinos" class="px-3 py-2 text-yellow-500 hover:text-yellow-400 focus:outline-none">Treinos</button>
                <button id="btnPlano" class="px-3 py-2 text-yellow-500 hover:text-yellow-400 focus:outline-none">Plano</button> <!-- Aba para o Plano -->
                <button id="btnContratos" class="px-3 py-2 text-yellow-500 hover:text-yellow-400 focus:outline-none">Contratos</button> <!-- Aba para Contratos -->
            </nav>

            <!-- Conteúdo das Abas -->
            <div id="infoAluno" class="mt-6">
                <x-aluno.aluno-info :aluno="$aluno" />
            </div>

            <div id="avaliacoesAluno" class="mt-6 hidden">
                <x-aluno.aluno-avaliacoes :aluno="$aluno" />
            </div>

            <div id="treinosAluno" class="mt-6 hidden">
                <x-aluno.aluno-treinos :aluno="$aluno" />
            </div>

            <div id="planoAluno" class="mt-6 hidden"> <!-- Seção para a aba Plano -->
                <x-aluno.aluno-plano :aluno="$aluno" />
            </div>

            <div id="contratosAluno" class="mt-6 hidden"> <!-- Seção para a aba Contratos -->
                <x-aluno.aluno-contratos :aluno="$aluno" />
            </div>
        </div>
    </div>

    <!-- Modal para adicionar treino -->
    <div id="modalAdicionarTreino" class="fixed inset-0 flex items-center justify-center z-50 hidden">
        <div class="bg-black bg-opacity-50 absolute inset-0"></div>
        <div class="bg-[#2d2d2d] p-6 rounded-md shadow-lg z-10">
            <h3 class="text-lg text-yellow-500 mb-4">Adicionar Treino</h3>
            <form id="formAdicionarTreino" action="{{ route('alunos.addTreino', $aluno->id) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="treino_id" class="block text-sm font-medium text-yellow-500">Selecione o Treino</label>
                    <select id="treino_id" name="treino_id" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" required>
                        @foreach($treinosDisponiveis as $treino)
                        <option value="{{ $treino->id }}">{{ $treino->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-end">
                    <button type="button" onclick="fecharModal()" class="px-4 py-2 bg-gray-500 text-white rounded-md mr-2 hover:bg-gray-600">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-700">Adicionar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Aqui entra o JavaScript que controla a página -->
    <script>
        function abrirModal() {
            document.getElementById('modalAdicionarTreino').classList.remove('hidden');
        }

        function fecharModal() {
            document.getElementById('modalAdicionarTreino').classList.add('hidden');
        }

        function habilitarEdicao() {
            var campos = document.querySelectorAll('input[type="text"], input[type="date"], select');
            campos.forEach(function(campo) {
                campo.removeAttribute('readonly');
                campo.removeAttribute('disabled');
            });
            document.getElementById('btnSalvar').style.display = 'block';
            document.getElementById('btnCancelar').style.display = 'inline-block';
        }

        function cancelarEdicao() {
            var campos = document.querySelectorAll('input[type="text"], input[type="date"], select');
            campos.forEach(function(campo) {
                campo.setAttribute('readonly', true);
                campo.setAttribute('disabled', true);
            });
            document.getElementById('btnSalvar').style.display = 'none';
            document.getElementById('btnCancelar').style.display = 'none';
        }

        function mostrarConfirmacao() {
            document.getElementById('confirmacaoModal').classList.remove('hidden');
        }

        function esconderConfirmacao() {
            document.getElementById('confirmacaoModal').classList.add('hidden');
        }

        function removerAvaliacao(id) {
            if (confirm('Tem certeza que deseja remover esta avaliação?')) {
                axios.delete(`/avaliacoes/${id}`)
                    .then(response => {
                        location.reload(); // Recarrega a página após excluir
                    })
                    .catch(error => {
                        console.error('Erro ao remover avaliação:', error);
                    });
            }
        }

        function removerTreino(id) {
            if (confirm('Tem certeza que deseja remover este treino?')) {
                axios.delete(`/treinos/${id}`)
                    .then(response => {
                        location.reload(); // Recarrega a página após excluir
                    })
                    .catch(error => {
                        console.error('Erro ao remover treino:', error);
                    });
            }
        }

        // Troca entre as abas
        document.getElementById('btnInfo').addEventListener('click', function() {
            document.getElementById('infoAluno').classList.remove('hidden');
            document.getElementById('avaliacoesAluno').classList.add('hidden');
            document.getElementById('treinosAluno').classList.add('hidden');
            document.getElementById('planoAluno').classList.add('hidden');
            document.getElementById('contratosAluno').classList.add('hidden'); // Esconde a aba contratos
        });

        document.getElementById('btnAvaliacoes').addEventListener('click', function() {
            document.getElementById('infoAluno').classList.add('hidden');
            document.getElementById('avaliacoesAluno').classList.remove('hidden');
            document.getElementById('treinosAluno').classList.add('hidden');
            document.getElementById('planoAluno').classList.add('hidden');
            document.getElementById('contratosAluno').classList.add('hidden'); // Esconde a aba contratos
        });

        document.getElementById('btnTreinos').addEventListener('click', function() {
            document.getElementById('infoAluno').classList.add('hidden');
            document.getElementById('avaliacoesAluno').classList.add('hidden');
            document.getElementById('treinosAluno').classList.remove('hidden');
            document.getElementById('planoAluno').classList.add('hidden');
            document.getElementById('contratosAluno').classList.add('hidden'); // Esconde a aba contratos
        });

        document.getElementById('btnPlano').addEventListener('click', function() {
            document.getElementById('infoAluno').classList.add('hidden');
            document.getElementById('avaliacoesAluno').classList.add('hidden');
            document.getElementById('treinosAluno').classList.add('hidden');
            document.getElementById('planoAluno').classList.remove('hidden');
            document.getElementById('contratosAluno').classList.add('hidden'); // Esconde a aba contratos
        });

        document.getElementById('btnContratos').addEventListener('click', function() { // Evento para a aba Contratos
            document.getElementById('infoAluno').classList.add('hidden');
            document.getElementById('avaliacoesAluno').classList.add('hidden');
            document.getElementById('treinosAluno').classList.add('hidden');
            document.getElementById('planoAluno').classList.add('hidden');
            document.getElementById('contratosAluno').classList.remove('hidden'); // Exibe a aba contratos
        });

        // Inicialização dos campos com formatação
        document.addEventListener('DOMContentLoaded', function() {
            new Cleave('#cpf', {
                delimiters: ['.', '.', '-'],
                blocks: [3, 3, 3, 2],
                numericOnly: true
            });
        });
    </script>
</x-app-layout>
