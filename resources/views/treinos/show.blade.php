<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-yellow-500 dark:text-yellow-500 leading-tight">
            {{ __('Detalhes do Treino') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#2d2d2d] overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-yellow-500 dark:text-yellow-500">
                    <form action="{{ route('treinos.update', $treino->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group flex flex-wrap mb-4">
                            <div class="w-full sm:w-1/2 px-2 mb-4 sm:mb-0">
                                <label for="nome" class="block text-sm font-medium text-yellow-500">Nome do Treino</label>
                                <input type="text" name="nome" id="nome" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" value="{{ $treino->nome }}" required readonly disabled>
                                @error('nome')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full sm:w-1/2 px-2">
                                <label for="tipo" class="block text-sm font-medium text-yellow-500">Tipo do Treino</label>
                                <select name="tipo" id="tipo" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" required disabled>
                                    <option value="iniciante" {{ $treino->tipo == 'iniciante' ? 'selected' : '' }}>Iniciante</option>
                                    <option value="intermediário" {{ $treino->tipo == 'intermediário' ? 'selected' : '' }}>Intermediário</option>
                                    <option value="avançado" {{ $treino->tipo == 'avançado' ? 'selected' : '' }}>Avançado</option>
                                </select>
                                @error('tipo')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        @foreach(['1', '2', '3'] as $dia)
                            <h3 class="text-xl font-semibold mb-4">Dia {{ $dia }}</h3>
                            <div class="form-group flex flex-wrap mb-4">
                                @for ($i = 1; $i <= 6; $i++)
                                    @php
                                        $exercicioTreino = $treino->exercicios->get($i - 1); // Pegando o exercício atual
                                    @endphp
                                    <div class="w-full flex items-center space-x-4 mb-4">
                                        <div class="w-full sm:w-1/2">
                                            <label for="dia{{ $dia }}_exercicio{{ $i }}" class="block text-sm font-medium text-yellow-500">Exercício {{ $i }}*</label>
                                            <select id="dia{{ $dia }}_exercicio{{ $i }}" name="dia{{ $dia }}_exercicios[]" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" disabled>
                                                @foreach ($exercicios as $exercicio)
                                                    <option value="{{ $exercicio->id }}" {{ $exercicioTreino && $exercicioTreino->id == $exercicio->id ? 'selected' : '' }}>
                                                        {{ $exercicio->nome }} - {{ $exercicio->grupo_muscular }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('dia{{ $dia }}_exercicios.' . ($i - 1))
                                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="w-1/4">
                                            <label for="dia{{ $dia }}_series{{ $i }}" class="block text-sm font-medium text-yellow-500">Séries*</label>
                                            <input type="number" id="dia{{ $dia }}_series{{ $i }}" name="dia{{ $dia }}_series[]" value="{{ $exercicioTreino ? $exercicioTreino->pivot->series : 1 }}" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" readonly disabled>
                                            @error('dia{{ $dia }}_series.' . ($i - 1))
                                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="w-1/4">
                                            <label for="dia{{ $dia }}_repeticoes{{ $i }}" class="block text-sm font-medium text-yellow-500">Repetições*</label>
                                            <input type="number" id="dia{{ $dia }}_repeticoes{{ $i }}" name="dia{{ $dia }}_repeticoes[]" value="{{ $exercicioTreino ? $exercicioTreino->pivot->repeticoes : 1 }}" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" readonly disabled>
                                            @error('dia{{ $dia }}_repeticoes.' . ($i - 1))
                                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        @endforeach

                        <div class="flex justify-end space-x-2">
                            <button type="button" onclick="habilitarEdicao()" id="btnEditar" class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600">Editar</button>
                            <button type="submit" id="btnSalvar" style="display: none;" class="bg-green-500 text-white font-bold py-2 px-4 rounded hover:bg-green-600">Salvar</button>
                            <button type="button" id="btnCancelar" style="display: none;" onclick="cancelarEdicao()" class="bg-red-500 text-white font-bold py-2 px-4 rounded hover:bg-red-600">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        var valoresOriginais = {};

        function habilitarEdicao() {
            var campos = document.querySelectorAll('input[type="text"], input[type="number"], select');
            campos.forEach(function(campo) {
                valoresOriginais[campo.name] = campo.value;
                campo.removeAttribute('readonly');
                campo.removeAttribute('disabled');
            });
            document.getElementById('btnSalvar').style.display = 'block';
            document.getElementById('btnCancelar').style.display = 'inline-block';
            document.getElementById('btnEditar').style.display = 'none';
        }

        function cancelarEdicao() {
            var campos = document.querySelectorAll('input[type="text"], input[type="number"], select');
            campos.forEach(function(campo) {
                campo.value = valoresOriginais[campo.name] || '';
                campo.setAttribute('readonly', true);
                campo.setAttribute('disabled', true);
            });
            document.getElementById('btnSalvar').style.display = 'none';
            document.getElementById('btnCancelar').style.display = 'none';
            document.getElementById('btnEditar').style.display = 'inline-block';
        }
    </script>
</x-app-layout>
