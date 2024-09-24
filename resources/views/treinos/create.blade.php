<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-yellow-500 dark:text-yellow-500 leading-tight">
            {{ __('Criar Novo Treino de 3 Dias') }}
        </h2>
        <button onclick="history.back()" class="text-yellow-500 hover:text-yellow-400">
            Voltar
        </button>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#2d2d2d] overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-yellow-500 dark:text-yellow-500">
                    <h2 class="text-2xl font-bold mb-4">Informações do Treino</h2>
                    <form action="{{ route('treinos.store') }}" method="POST">
                        @csrf

                        <div class="form-group flex flex-wrap mb-4">
                            <div class="w-full sm:w-1/2 px-2">
                                <label for="nome" class="block text-sm font-medium text-yellow-500">Nome do
                                    Treino*</label>
                                <input type="text" id="nome" name="nome" value="{{ old('nome') }}"
                                    class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                                @error('nome')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full sm:w-1/2 px-2">
                                <label for="tipo" class="block text-sm font-medium text-yellow-500">Tipo do
                                    Treino*</label>
                                <select id="tipo" name="tipo"
                                    class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                                    <option value="iniciante" {{ old('tipo') == 'iniciante' ? 'selected' : '' }}>Iniciante</option>
                                    <option value="intermediário" {{ old('tipo') == 'intermediário' ? 'selected' : '' }}>Intermediário</option>
                                    <option value="avançado" {{ old('tipo') == 'avançado' ? 'selected' : '' }}>Avançado</option>
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
                                <div class="w-full flex items-center space-x-4 mb-4">
                                <div class="w-full sm:w-1/2">
                                    <label for="dia{{ $dia }}_exercicio{{ $i }}"
                                        class="block text-sm font-medium text-yellow-500">Exercício {{ $i }}*</label>
                                    <select id="dia{{ $dia }}_exercicio{{ $i }}" name="dia{{ $dia }}_exercicios[]"
                                        class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                                        @foreach ($exercicios as $exercicio)
                                        <option value="{{ $exercicio->id }}" {{ old("dia{$dia}_exercicios.$i") == $exercicio->id ? 'selected' : '' }}>{{ $exercicio->nome }} -
                                            {{ $exercicio->grupo_muscular }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error("dia{$dia}_exercicios." . ($i - 1))
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="w-1/4">
                                    <label for="dia{{ $dia }}_series{{ $i }}"
                                        class="block text-sm font-medium text-yellow-500">Séries*</label>
                                    <input type="number" id="dia{{ $dia }}_series{{ $i }}" name="dia{{ $dia }}_series[]"
                                        value="{{ old('dia' . $dia . '_series.' . ($i - 1)) }}"
                                        class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                                    @error("dia{$dia}_series." . ($i - 1))
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="w-1/4">
                                    <label for="dia{{ $dia }}_repeticoes{{ $i }}"
                                        class="block text-sm font-medium text-yellow-500">Repetições*</label>
                                    <input type="number" id="dia{{ $dia }}_repeticoes{{ $i }}"
                                        name="dia{{ $dia }}_repeticoes[]"
                                        value="{{ old('dia' . $dia . '_repeticoes.' . ($i - 1)) }}"
                                        class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                                    @error("dia{$dia}_repeticoes." . ($i - 1))
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                        </div>
                        @endfor
                </div>
                @endforeach

                <div class="flex justify-end space-x-4">
                    <div class="w-auto">
                        <button type="submit" class="bg-green-500 text-white font-bold py-2 px-4 rounded hover:bg-green-600">
                            Salvar Treino
                        </button>
                    </div>
                    <div class="w-auto">
                        <a href="{{ route('treinos.index') }}" class="bg-red-500 text-white font-bold py-2 px-4 rounded hover:bg-red-600">
                            Cancelar
                        </a>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>

    <!-- Incluindo as bibliotecas jQuery e jQuery UI para autocompletar -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</x-app-layout>