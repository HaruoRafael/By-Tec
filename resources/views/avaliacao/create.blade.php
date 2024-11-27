<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-yellow-500 dark:text-yellow-500 leading-tight">
            {{ __('Criar Avaliação') }}
        </h2>
        <button onclick="history.back()" class="text-yellow-500 hover:text-yellow-400">
            Voltar
        </button>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#2d2d2d] overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-yellow-500 dark:text-yellow-500">
                    <h2 class="text-2xl font-bold mb-4">Informações da Avaliação</h2>
                    <form action="{{ route('avaliacao.store', $aluno->id) }}" method="POST">
                        @csrf
                        <!-- Avaliador e Data -->
                        <div class="form-group flex flex-wrap mb-4">
                            <div class="w-full sm:w-1/2 px-2">
                                <label for="avaliador" class="block text-sm font-medium text-yellow-500">Avaliador*</label>
                                <input type="text" id="avaliador" name="avaliador" value="{{ old('avaliador') }}"
                                    class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" 
                                    placeholder="Nome do Avaliador" required>
                                @error('avaliador')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full sm:w-1/2 px-2">
                                <label for="data" class="block text-sm font-medium text-yellow-500">Data*</label>
                                <input type="date" id="data" name="data" value="{{ old('data') }}"
                                    class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" required>
                                @error('data')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Altura e Idade -->
                        <div class="form-group flex flex-wrap mb-4">
                            <div class="w-full sm:w-1/2 px-2">
                                <label for="altura" class="block text-sm font-medium text-yellow-500">Altura (m)*</label>
                                <input type="number" step="0.01" id="altura" name="altura" value="{{ old('altura') }}"
                                    class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                                    min="0.5" max="3" placeholder="Ex: 1.75" required>
                                @error('altura')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full sm:w-1/2 px-2">
                                <label for="idade" class="block text-sm font-medium text-yellow-500">Idade (anos)*</label>
                                <input type="number" id="idade" name="idade" value="{{ old('idade') }}"
                                    class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                                    min="1" max="120" placeholder="Ex: 25" required>
                                @error('idade')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Peso e % Gordura -->
                        <div class="form-group flex flex-wrap mb-4">
                            <div class="w-full sm:w-1/2 px-2">
                                <label for="peso" class="block text-sm font-medium text-yellow-500">Peso (kg)*</label>
                                <input type="number" step="0.1" id="peso" name="peso" value="{{ old('peso') }}"
                                    class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                                    min="1" max="300" placeholder="Ex: 70.5" required>
                                @error('peso')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full sm:w-1/2 px-2">
                                <label for="porcentagem_gordura" class="block text-sm font-medium text-yellow-500">% Gordura*</label>
                                <input type="number" step="0.1" id="porcentagem_gordura" name="porcentagem_gordura" value="{{ old('porcentagem_gordura') }}"
                                    class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                                    min="0" max="100" placeholder="Ex: 15.5" required>
                                @error('porcentagem_gordura')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Parte Gordura -->
                        <h3 class="text-xl font-semibold mb-4">Parte Gordura</h3>
                        <div class="form-group flex flex-wrap mb-4">
                            @foreach(['braco_direito_gordura' => 'Braço Direito', 'braco_esquerdo_gordura' => 'Braço Esquerdo', 'perna_direita_gordura' => 'Perna Direita', 'perna_esquerda_gordura' => 'Perna Esquerda', 'tronco_gordura' => 'Tronco'] as $field => $label)
                            <div class="w-full sm:w-1/2 px-2">
                                <label for="{{ $field }}" class="block text-sm font-medium text-yellow-500">{{ $label }}*</label>
                                <input type="number" step="0.1" id="{{ $field }}" name="{{ $field }}" value="{{ old($field) }}"
                                    class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                                    min="0" max="100" placeholder="Ex: 20.5" required>
                                @error($field)
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            @endforeach
                        </div>

                        <!-- Parte Massa Muscular -->
                        <h3 class="text-xl font-semibold mb-4">Parte Massa Muscular</h3>
                        <div class="form-group flex flex-wrap mb-4">
                            @foreach(['massa_muscular' => 'Massa Muscular', 'braco_direito_muscular' => 'Braço Direito', 'braco_esquerdo_muscular' => 'Braço Esquerdo', 'perna_direita_muscular' => 'Perna Direita', 'perna_esquerda_muscular' => 'Perna Esquerda', 'tronco_muscular' => 'Tronco'] as $field => $label)
                            <div class="w-full sm:w-1/2 px-2">
                                <label for="{{ $field }}" class="block text-sm font-medium text-yellow-500">{{ $label }}*</label>
                                <input type="number" step="0.1" id="{{ $field }}" name="{{ $field }}" value="{{ old($field) }}"
                                    class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                                    min="1" max="200" placeholder="Ex: 50.0" required>
                                @error($field)
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            @endforeach
                        </div>

                        <!-- Escala Constituição -->
                        <h3 class="text-xl font-semibold mb-4">Escala Constituição</h3>
                        <div class="form-group flex flex-wrap mb-4">
                            @foreach(['massa_ossea' => 'Massa Óssea', 'gordura_visceral' => 'Gordura Visceral', 'porcentagem_agua' => '% Água', 'taxa_metabolica_basal' => 'Taxa Metabólica Basal', 'idade_metabolica' => 'Idade Metabólica'] as $field => $label)
                            <div class="w-full sm:w-1/2 px-2">
                                <label for="{{ $field }}" class="block text-sm font-medium text-yellow-500">{{ $label }}*</label>
                                <input type="number" step="0.1" id="{{ $field }}" name="{{ $field }}" value="{{ old($field) }}"
                                    class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                                    min="{{ $field === 'idade_metabolica' ? 1 : 0 }}" 
                                    max="{{ $field === 'idade_metabolica' ? 120 : ($field === 'taxa_metabolica_basal' ? 5000 : 100) }}" 
                                    placeholder="Ex: 5.0" required>
                                @error($field)
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            @endforeach
                        </div>

                        <!-- Botão de Submissão -->
                        <div class="form-group flex flex-wrap mb-4">
                            <div class="w-full px-2">
                                <button type="submit" class="bg-green-500 text-white font-bold py-2 px-4 rounded hover:bg-green-600">Salvar</button>
                            </div>
                        </div>
                    </form>

                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const camposNumericos = document.querySelectorAll('input[type="number"]');

                            camposNumericos.forEach(campo => {
                                campo.addEventListener('input', () => {
                                    let valor = parseFloat(campo.value);
                                    const min = parseFloat(campo.getAttribute('min')) || null;
                                    const max = parseFloat(campo.getAttribute('max')) || null;

                                    if (min !== null && valor < min) campo.value = min.toFixed(2);
                                    if (max !== null && valor > max) campo.value = max.toFixed(2);
                                });
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
