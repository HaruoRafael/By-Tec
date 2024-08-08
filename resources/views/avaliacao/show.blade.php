<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-yellow-500 dark:text-yellow-500 leading-tight">
            {{ __('Detalhes da Avaliação') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#2d2d2d] overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-yellow-500 dark:text-yellow-500">
                    <form action="{{ route('avaliacoes.update', $avaliacao->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group flex flex-wrap mb-4">
                            <div class="w-full sm:w-1/2 px-2">
                                <label for="avaliador" class="block text-sm font-medium text-yellow-500">Avaliador</label>
                                <input type="text" id="avaliador" name="avaliador" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" value="{{ $avaliacao->avaliador }}" required readonly disabled>
                                @error('avaliador')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full sm:w-1/2 px-2">
                                <label for="data" class="block text-sm font-medium text-yellow-500">Data</label>
                                <input type="date" id="data" name="data" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" value="{{ $avaliacao->data }}" required readonly disabled>
                                @error('data')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group flex flex-wrap mb-4">
                            <div class="w-full sm:w-1/2 px-2">
                                <label for="altura" class="block text-sm font-medium text-yellow-500">Altura</label>
                                <input type="number" step="0.01" id="altura" name="altura" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" value="{{ $avaliacao->altura }}" required readonly disabled>
                                @error('altura')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full sm:w-1/2 px-2">
                                <label for="idade" class="block text-sm font-medium text-yellow-500">Idade</label>
                                <input type="number" id="idade" name="idade" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" value="{{ $avaliacao->idade }}" required readonly disabled>
                                @error('idade')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group flex flex-wrap mb-4">
                            <div class="w-full sm:w-1/2 px-2">
                                <label for="peso" class="block text-sm font-medium text-yellow-500">Peso</label>
                                <input type="number" step="0.1" id="peso" name="peso" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" value="{{ $avaliacao->peso }}" required readonly disabled>
                                @error('peso')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full sm:w-1/2 px-2">
                                <label for="porcentagem_gordura" class="block text-sm font-medium text-yellow-500">% Gordura</label>
                                <input type="number" step="0.1" id="porcentagem_gordura" name="porcentagem_gordura" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" value="{{ $avaliacao->porcentagem_gordura }}" required readonly disabled>
                                @error('porcentagem_gordura')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <h3 class="text-xl font-semibold mb-4">Parte Gordura</h3>
                        <div class="form-group flex flex-wrap mb-4">
                            @foreach(['braco_direito_gordura' => 'Braço Direito', 'braco_esquerdo_gordura' => 'Braço Esquerdo', 'perna_direita_gordura' => 'Perna Direita', 'perna_esquerda_gordura' => 'Perna Esquerda', 'tronco_gordura' => 'Tronco'] as $field => $label)
                                <div class="w-full sm:w-1/2 px-2">
                                    <label for="{{ $field }}" class="block text-sm font-medium text-yellow-500">{{ $label }}</label>
                                    <input type="number" step="0.1" id="{{ $field }}" name="{{ $field }}" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" value="{{ $avaliacao->$field }}" required readonly disabled>
                                    @error($field)
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endforeach
                        </div>

                        <h3 class="text-xl font-semibold mb-4">Parte Massa Muscular</h3>
                        <div class="form-group flex flex-wrap mb-4">
                            @foreach(['massa_muscular' => 'Massa Muscular', 'braco_direito_muscular' => 'Braço Direito', 'braco_esquerdo_muscular' => 'Braço Esquerdo', 'perna_direita_muscular' => 'Perna Direita', 'perna_esquerda_muscular' => 'Perna Esquerda', 'tronco_muscular' => 'Tronco'] as $field => $label)
                                <div class="w-full sm:w-1/2 px-2">
                                    <label for="{{ $field }}" class="block text-sm font-medium text-yellow-500">{{ $label }}</label>
                                    <input type="number" step="0.1" id="{{ $field }}" name="{{ $field }}" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" value="{{ $avaliacao->$field }}" required readonly disabled>
                                    @error($field)
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endforeach
                        </div>

                        <h3 class="text-xl font-semibold mb-4">Escala Constituição</h3>
                        <div class="form-group flex flex-wrap mb-4">
                            @foreach(['massa_ossea' => 'Massa Óssea', 'gordura_visceral' => 'Gordura Visceral', 'porcentagem_agua' => '% Água', 'taxa_metabolica_basal' => 'Taxa Metabólica Basal', 'idade_metabolica' => 'Idade Metabólica'] as $field => $label)
                                <div class="w-full sm:w-1/2 px-2">
                                    <label for="{{ $field }}" class="block text-sm font-medium text-yellow-500">{{ $label }}</label>
                                    <input type="number" step="0.1" id="{{ $field }}" name="{{ $field }}" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" value="{{ $avaliacao->$field }}" required readonly disabled>
                                    @error($field)
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endforeach
                        </div>

                        <div class="flex justify-end space-x-2 mt-4">
                            <button type="button" onclick="habilitarEdicao()" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700">Editar</button>
                            <button type="submit" id="btnSalvar" style="display: none;" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-700">Salvar</button>
                            <button type="button" id="btnCancelar" style="display: none;" onclick="cancelarEdicao()" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-700">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        var valoresOriginais = {};

        function habilitarEdicao() {
            var campos = document.querySelectorAll('input[type="text"], input[type="number"], input[type="date"], select, textarea');
            campos.forEach(function(campo) {
                valoresOriginais[campo.name] = campo.value;
                campo.removeAttribute('readonly');
                campo.removeAttribute('disabled');
            });
            document.getElementById('btnSalvar').style.display = 'block';
            document.getElementById('btnCancelar').style.display = 'inline-block';
        }

        function cancelarEdicao() {
            var campos = document.querySelectorAll('input[type="text"], input[type="number"], input[type="date"], select, textarea');
            campos.forEach(function(campo) {
                campo.value = valoresOriginais[campo.name] || '';
                campo.setAttribute('readonly', true);
                campo.setAttribute('disabled', true);
            });
            document.getElementById('btnSalvar').style.display = 'none';
            document.getElementById('btnCancelar').style.display = 'none';
        }
    </script>
</x-app-layout>
