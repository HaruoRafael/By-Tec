<div class="bg-[#2d2d2d] overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-yellow-500 dark:text-yellow-500">
        <h2 class="font-semibold text-xl text-yellow-500 dark:text-yellow-500 leading-tight">
            {{ __('Avaliações') }}
        </h2>

        <!-- Botão para Criar Avaliação -->
        <button id="criarAvaliacaoBtn" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700">
            Criar Avaliação
        </button>

        @if($aluno->avaliacoes->isEmpty())
        <p class="mt-4">Este aluno ainda não possui avaliações.</p>
        @else
        <table class="min-w-full bg-[#2d2d2d] mt-4">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-left text-xs text-yellow-500 uppercase tracking-wider">Data</th>
                    <th class="px-4 py-2 text-left text-xs text-yellow-500 uppercase tracking-wider">Avaliador</th>
                    <th class="px-4 py-2 text-left text-xs text-yellow-500 uppercase tracking-wider">Detalhes</th>
                    <th class="px-4 py-2 text-left text-xs text-yellow-500 uppercase tracking-wider">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($aluno->avaliacoes as $avaliacao)
                <tr id="avaliacao-{{ $avaliacao->id }}" class="bg-[#2d2d2d]">
                    <td class="border px-4 py-2 text-yellow-500">{{ $avaliacao->data }}</td>
                    <td class="border px-4 py-2 text-yellow-500">{{ $avaliacao->avaliador }}</td>
                    <td class="border px-4 py-2 text-yellow-500">
                        <a href="{{ route('avaliacao.show', $avaliacao->id) }}" class="text-blue-500 hover:underline">Ver detalhes</a>
                    </td>
                    <td class="border px-4 py-2 text-yellow-500">
                        <button type="button" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-700" data-avaliacao-id="{{ $avaliacao->id }}">Remover</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>

<!-- JavaScript separado -->
<script>
    // Função para abrir a página de criação de avaliação
    document.getElementById('criarAvaliacaoBtn').addEventListener('click', function() {
        window.location.href = "{{ route('avaliacao.create', $aluno->id) }}";
    });

    // Função para remover avaliação
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

    // Aplicar o evento de remoção a todos os botões de remoção
    document.querySelectorAll('button[data-avaliacao-id]').forEach(function(button) {
        button.addEventListener('click', function() {
            var avaliacaoId = this.getAttribute('data-avaliacao-id');
            removerAvaliacao(avaliacaoId);
        });
    });
</script>
