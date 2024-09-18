<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-yellow-500 dark:text-yellow-500 leading-tight">
            {{ __('Detalhes do Plano') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#2d2d2d] overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-yellow-500 dark:text-yellow-500">
                    <form action="{{ route('planos.update', $plano->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group flex flex-wrap mb-4">
                            <div class="w-full sm:w-1/2 px-2 mb-4 sm:mb-0">
                                <label for="nome" class="block text-sm font-medium text-yellow-500">Nome</label>
                                <input type="text" name="nome" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" value="{{ $plano->nome }}" required readonly disabled>
                                @error('nome')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full sm:w-1/2 px-2">
                                <label for="valor" class="block text-sm font-medium text-yellow-500">Valor (R$)</label>
                                <input type="number" step="0.01" name="valor" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" value="{{ $plano->valor }}" required readonly disabled>
                                @error('valor')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group flex flex-wrap mb-4">
                            <div class="w-full sm:w-1/2 px-2 mb-4 sm:mb-0">
                                <label for="duracao" class="block text-sm font-medium text-yellow-500">Duração (meses)</label>
                                <input type="number" name="duracao" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" value="{{ $plano->duracao }}" required readonly disabled>
                                @error('duracao')
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
                </div>
            </div>
        </div>
    </div>

    <script>
        var valoresOriginais = {};

        function habilitarEdicao() {
            var campos = document.querySelectorAll('input[type="text"], input[type="number"], textarea');
            campos.forEach(function(campo) {
                valoresOriginais[campo.name] = campo.value;
                campo.removeAttribute('readonly');
                campo.removeAttribute('disabled');
            });
            document.getElementById('btnSalvar').style.display = 'block';
            document.getElementById('btnCancelar').style.display = 'inline-block';
        }

        function cancelarEdicao() {
            var campos = document.querySelectorAll('input[type="text"], input[type="number"], textarea');
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
