<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-yellow-500 dark:text-yellow-500 leading-tight">
            {{ __('Detalhes do Funcionário') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#2d2d2d] overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-yellow-500 dark:text-yellow-500">
                    <h2 class="text-2xl font-bold mb-4">Informações do Funcionário</h2>
                    <form action="{{ route('funcionarios.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-yellow-500">Nome Completo</label>
                            <input type="text" id="name" name="name" value="{{ $user->name }}" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 bg-white" readonly disabled>
                            @error('name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex flex-wrap -mx-2 mb-4">
                            <div class="w-full sm:w-1/2 px-2 mb-4 sm:mb-0">
                                <label for="cpf" class="block text-sm font-medium text-yellow-500">CPF</label>
                                <input type="text" id="cpf" name="cpf" value="{{ $user->cpf }}" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 bg-white" readonly disabled>
                                @error('cpf')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full sm:w-1/2 px-2">
                                <label for="rg" class="block text-sm font-medium text-yellow-500">RG</label>
                                <input type="text" id="rg" name="rg" value="{{ $user->rg }}" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 bg-white" readonly disabled>
                                @error('rg')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="flex flex-wrap -mx-2 mb-4">
                            <div class="w-full sm:w-1/2 px-2 mb-4 sm:mb-0">
                                <label for="telefone" class="block text-sm font-medium text-yellow-500">Telefone</label>
                                <input type="text" id="telefone" name="telefone" value="{{ $user->telefone }}" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 bg-white" readonly disabled>
                                @error('telefone')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full sm:w-1/2 px-2">
                                <label for="sexo" class="block text-sm font-medium text-yellow-500">Sexo</label>
                                <select id="sexo" name="sexo" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 bg-white" readonly disabled>
                                    <option value="M" {{ $user->sexo == 'M' ? 'selected' : '' }}>Masculino</option>
                                    <option value="F" {{ $user->sexo == 'F' ? 'selected' : '' }}>Feminino</option>
                                    <option value="Outro" {{ $user->sexo == 'Outro' ? 'selected' : '' }}>Outro</option>
                                </select>
                                @error('sexo')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="flex flex-wrap -mx-2 mb-4">
                            <div class="w-full sm:w-1/2 px-2 mb-4 sm:mb-0">
                                <label for="data_nascimento" class="block text-sm font-medium text-yellow-500">Data de Nascimento</label>
                                <input type="date" id="data_nascimento" name="data_nascimento" value="{{ $user->data_nascimento ? $user->data_nascimento->format('Y-m-d') : '' }}" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 bg-white" readonly disabled>
                                @error('data_nascimento')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full sm:w-1/2 px-2">
                                <label for="endereco" class="block text-sm font-medium text-yellow-500">Endereço</label>
                                <input type="text" id="endereco" name="endereco" value="{{ $user->endereco }}" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 bg-white" readonly disabled>
                                @error('endereco')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="cargo" class="block text-sm font-medium text-yellow-500">Cargo</label>
                            <select id="cargo" name="cargo" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 bg-white" readonly disabled>
                                <option value="Professor" {{ $user->cargo == 'Professor' ? 'selected' : '' }}>Professor</option>
                                <option value="Recepcionista" {{ $user->cargo == 'Recepcionista' ? 'selected' : '' }}>Recepcionista</option>
                                <option value="Administrador" {{ $user->cargo == 'Administrador' ? 'selected' : '' }}>Administrador</option>
                            </select>
                            @error('cargo')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-yellow-500">Email</label>
                            <input type="email" id="email" name="email" value="{{ $user->email }}" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 bg-white" required readonly disabled>
                            @error('email')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
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
            var campos = document.querySelectorAll('input, select, textarea');
            campos.forEach(function(campo) {
                valoresOriginais[campo.name] = campo.value;
                campo.removeAttribute('readonly');
                campo.removeAttribute('disabled');
            });
            document.getElementById('btnSalvar').style.display = 'block';
            document.getElementById('btnCancelar').style.display = 'inline-block';
        }

        function cancelarEdicao() {
            var campos = document.querySelectorAll('input, select, textarea');
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
