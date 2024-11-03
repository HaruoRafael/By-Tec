<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-yellow-500 dark:text-yellow-500 leading-tight">
            {{ __('Detalhes do Exercício') }}
        </h2>
        <x-nav-link :href="route('exercicios.index')" :active="request()->routeIs('exercicios.index')"
            class="text-yellow-500 hover:text-yellow-400">
            {{ __('Exercicios') }}
        </x-nav-link>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#2d2d2d] overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-yellow-500 dark:text-yellow-500">
                    <form action="{{ route('exercicios.update', $exercicio->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group flex flex-wrap mb-4">
                            <div class="w-full sm:w-1/2 px-2 mb-4 sm:mb-0">
                                <label for="nome" class="block text-sm font-medium text-yellow-500">Nome*</label>
                                <input type="text" id="nome" name="nome" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" value="{{ $exercicio->nome }}" required readonly disabled>
                                @error('nome')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full sm:w-1/2 px-2">
                                <label for="grupo_muscular" class="block text-sm font-medium text-yellow-500">Grupo Muscular*</label>
                                <input type="text" id="grupo_muscular" name="grupo_muscular" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" value="{{ $exercicio->grupo_muscular }}" required readonly disabled>
                                @error('grupo_muscular')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group flex flex-wrap mb-4">
                            <div class="w-full sm:w-1/2 px-2 mb-4 sm:mb-0">
                                <label for="dificuldade" class="block text-sm font-medium text-yellow-500">Dificuldade*</label>
                                <select name="dificuldade" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" required disabled>
                                    <option value="easy" {{ $exercicio->dificuldade == 'easy' ? 'selected' : '' }}>Fácil</option>
                                    <option value="normal" {{ $exercicio->dificuldade == 'normal' ? 'selected' : '' }}>Normal</option>
                                    <option value="hard" {{ $exercicio->dificuldade == 'hard' ? 'selected' : '' }}>Difícil</option>
                                </select>
                                @error('dificuldade')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full sm:w-1/2 px-2">
                                <label for="observacoes" class="block text-sm font-medium text-yellow-500">Observações*</label>
                                <textarea name="observacoes" rows="4" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 p-3 resize-none" placeholder="Insira qualquer observação relevante aqui..."></textarea>
                                @error('observacoes')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="flex justify-end space-x-2">
                            <button type="button" onclick="habilitarEdicao()" class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600">Editar</button>
                            <button type="submit" id="btnSalvar" style="display: none;" class="bg-green-500 text-white font-bold py-2 px-4 rounded hover:bg-green-600">Salvar</button>
                            <button type="button" id="btnCancelar" style="display: none;" onclick="cancelarEdicao()" class="bg-red-500 text-white font-bold py-2 px-4 rounded hover:bg-red-600">Cancelar</button>
                        </div>
                    </form>
                    <form action="{{ route('exercicios.destroy', $exercicio->id) }}" method="POST" class="mt-4">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white font-bold py-2 px-4 rounded hover:bg-red-600"
                            onclick="return confirm('Tem certeza que deseja excluir este exercício?')">
                            Excluir Exercício
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        var valoresOriginais = {};

        function habilitarEdicao() {
            var campos = document.querySelectorAll('input[type="text"], select, textarea');
            campos.forEach(function(campo) {
                valoresOriginais[campo.name] = campo.value;
                campo.removeAttribute('readonly');
                campo.removeAttribute('disabled');
            });
            document.getElementById('btnSalvar').style.display = 'block';
            document.getElementById('btnCancelar').style.display = 'inline-block';

            // Adiciona o listener para impedir caracteres acentuados nos campos específicos
            document.getElementById('nome').addEventListener('input', function() {
                removeAcentos(this);
            });
            document.getElementById('grupo_muscular').addEventListener('input', function() {
                removeAcentos(this);
            });
        }

        function cancelarEdicao() {
            var campos = document.querySelectorAll('input[type="text"], select, textarea');
            campos.forEach(function(campo) {
                campo.value = valoresOriginais[campo.name] || '';
                campo.setAttribute('readonly', true);
                campo.setAttribute('disabled', true);
            });
            document.getElementById('btnSalvar').style.display = 'none';
            document.getElementById('btnCancelar').style.display = 'none';
        }

        function removeAcentos(element) {
            let value = element.value;
            element.value = value.normalize('NFD').replace(/[\u0300-\u036f]/g, '').replace(/[^a-zA-Z\s]/g, '');
        }
    </script>
</x-app-layout>
