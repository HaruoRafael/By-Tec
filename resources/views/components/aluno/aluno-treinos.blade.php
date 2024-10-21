<div class="bg-[#2d2d2d] overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-yellow-500 dark:text-yellow-500">
        <h2 class="font-semibold text-xl text-yellow-500 dark:text-yellow-500 leading-tight">
            {{ __('Treinos') }}
        </h2>

        <button class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700" onclick="abrirModal()">Adicionar Treino</button>

        @if($aluno->treinos->isEmpty())
        <p class="mt-4">Este aluno ainda não possui treinos associados.</p>
        @else
        <table class="min-w-full bg-[#2d2d2d] mt-4">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-left text-xs text-yellow-500 uppercase tracking-wider">Nome do Treino</th>
                    <th class="px-4 py-2 text-left text-xs text-yellow-500 uppercase tracking-wider">Detalhes</th>
                    <th class="px-4 py-2 text-left text-xs text-yellow-500 uppercase tracking-wider">Ações</th>
                </tr>
            </thead>
            <tbody>
                
                @foreach($aluno->treinos as $treino)
                <tr class="bg-[#2d2d2d]">
                    <td class="border px-4 py-2 text-yellow-500">{{ $treino->nome }}</td>
                    <td class="border px-4 py-2 text-yellow-500">
                        <a href="{{ route('treinos.show', $treino->id) }}" class="text-blue-500 hover:underline">Ver detalhes</a>
                    </td>
                    <td class="border px-4 py-2 text-yellow-500">
                        <form action="{{ route('alunos.removeTreino', ['aluno' => $aluno->id, 'treino' => $treino->id]) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja remover este treino do perfil do aluno?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-700">Remover</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
