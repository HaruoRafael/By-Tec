<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-yellow-500 dark:text-yellow-500 leading-tight">
            {{ __('Criar Novo Exercício') }}
        </h2>
        <button onclick="history.back()" class="text-yellow-500 hover:text-yellow-400">
            Voltar
        </button>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#2d2d2d] overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-yellow-500 dark:text-yellow-500">
                    <form action="{{ route('exercicios.store') }}" method="POST">
                        @csrf
                        <div class="form-group flex flex-wrap mb-4">
                            <div class="w-full sm:w-1/2 px-2 mb-4 sm:mb-0">
                                <label for="nome" class="block text-sm font-medium text-yellow-500">Nome*</label>
                                <input type="text" id="nome" name="nome" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" required>
                                @error('nome')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full sm:w-1/2 px-2">
                                <label for="grupo_muscular" class="block text-sm font-medium text-yellow-500">Grupo Muscular*</label>
                                <input type="text" id="grupo_muscular" name="grupo_muscular" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" required>
                                @error('grupo_muscular')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group flex flex-wrap mb-4">
                            <div class="w-full sm:w-1/2 px-2 mb-4 sm:mb-0">
                                <label for="dificuldade" class="block text-sm font-medium text-yellow-500">Dificuldade*</label>
                                <select name="dificuldade" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" required>
                                    <option value="easy">Fácil</option>
                                    <option value="normal">Normal</option>
                                    <option value="hard">Difícil</option>
                                </select>
                                @error('dificuldade')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full sm:w-1/2 px-2">
                                <label for="observacoes" class="block text-sm font-medium text-yellow-500">Observações</label>
                                <textarea name="observacoes" rows="4" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 p-3 resize-none" placeholder="Insira qualquer observação relevante aqui..."></textarea>
                                @error('observacoes')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('exercicios.index') }}" class="bg-red-500 text-white font-bold py-2 px-4 rounded hover:bg-red-600">
                                Cancelar
                            </a>
                            <button type="submit" class="bg-green-500 text-white font-bold py-2 px-4 rounded hover:bg-green-600">
                                Salvar
                            </button>
                        </div>
                    </form>

                    <script>
                        function removeCaracteresIndesejados(element) {
                            let value = element.value;
                            // Permitir letras, números, espaços e acentos
                            element.value = value.replace(/[^a-zA-ZÀ-ÿ0-9\s]/g, '');
                        }

                        document.getElementById('nome').addEventListener('input', function() {
                            removeCaracteresIndesejados(this);
                        });

                        document.getElementById('grupo_muscular').addEventListener('input', function() {
                            removeCaracteresIndesejados(this);
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
