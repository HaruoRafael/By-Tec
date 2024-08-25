<!-- resources/views/funcionarios/create.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-yellow-500 dark:text-yellow-500 leading-tight">
            {{ __('Criar Conta de Usuário') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#2d2d2d] overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-yellow-500 dark:text-yellow-500">
                    <h2 class="text-2xl font-bold mb-4">Informações do Usuário</h2>
                    <form action="{{ route('funcionarios.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="nome" class="block text-sm font-medium text-yellow-500">Nome Completo*</label>
                            <input type="text" id="nome" name="nome" value="{{ old('nome') }}" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                            @error('nome')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex flex-wrap -mx-2 mb-4">
                            <div class="w-full sm:w-1/2 px-2 mb-4 sm:mb-0">
                                <label for="cpf" class="block text-sm font-medium text-yellow-500">CPF*</label>
                                <input type="text" id="cpf" name="cpf" maxlength="14" placeholder="123.456.789-00" value="{{ old('cpf') }}" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                                @error('cpf')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full sm:w-1/2 px-2">
                                <label for="rg" class="block text-sm font-medium text-yellow-500">RG</label>
                                <input type="text" id="rg" name="rg" value="{{ old('rg') }}" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                                @error('rg')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="flex flex-wrap -mx-2 mb-4">
                            <div class="w-full sm:w-1/2 px-2 mb-4 sm:mb-0">
                                <label for="telefone" class="block text-sm font-medium text-yellow-500">Telefone</label>
                                <input type="text" id="telefone" name="telefone" value="{{ old('telefone') }}" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                                @error('telefone')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full sm:w-1/2 px-2">
                                <label for="sexo" class="block text-sm font-medium text-yellow-500">Sexo</label>
                                <select id="sexo" name="sexo" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                                    <option value="M" {{ old('sexo') == 'M' ? 'selected' : '' }}>Masculino</option>
                                    <option value="F" {{ old('sexo') == 'F' ? 'selected' : '' }}>Feminino</option>
                                    <option value="Outro" {{ old('sexo') == 'Outro' ? 'selected' : '' }}>Outro</option>
                                </select>
                                @error('sexo')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="flex flex-wrap -mx-2 mb-4">
                            <div class="w-full sm:w-1/2 px-2 mb-4 sm:mb-0">
                                <label for="data_nascimento" class="block text-sm font-medium text-yellow-500">Data de Nascimento*</label>
                                <input type="date" id="data_nascimento" name="data_nascimento" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" max="{{ date('Y-m-d') }}" value="{{ old('data_nascimento') }}">
                                @error('data_nascimento')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full sm:w-1/2 px-2">
                                <label for="endereco" class="block text-sm font-medium text-yellow-500">Endereço</label>
                                <input type="text" id="endereco" name="endereco" value="{{ old('endereco') }}" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                                @error('endereco')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="cargo" class="block text-sm font-medium text-yellow-500">Cargo*</label>
                            <select id="cargo" name="cargo" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                                <option value="Professor" {{ old('cargo') == 'Professor' ? 'selected' : '' }}>Professor</option>
                                <option value="Recepcionista" {{ old('cargo') == 'Recepcionista' ? 'selected' : '' }}>Recepcionista</option>
                                <option value="Administrador" {{ old('cargo') == 'Administrador' ? 'selected' : '' }}>Administrador</option>
                            </select>
                            @error('cargo')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-yellow-500">Email*</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                            @error('email')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex flex-wrap -mx-2 mb-4">
                            <div class="w-full sm:w-1/2 px-2 mb-4 sm:mb-0">
                                <label for="password" class="block text-sm font-medium text-yellow-500">Senha*</label>
                                <input type="password" id="password" name="password" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                                @error('password')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full sm:w-1/2 px-2">
                                <label for="password_confirmation" class="block text-sm font-medium text-yellow-500">Confirmar Senha*</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                                @error('password_confirmation')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-green-500 text-white font-bold py-2 px-4 rounded hover:bg-green-600">Salvar</button>
                        </div>
                    </form>

                    <!-- Inclui a biblioteca Cleave.js -->
                    <script src="https://cdn.jsdelivr.net/npm/cleave.js@1.6.0/dist/cleave.min.js"></script>
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            new Cleave('#cpf', {
                                delimiters: ['.', '.', '-'],
                                blocks: [3, 3, 3, 2],
                                numericOnly: true
                            });

                            document.getElementById('rg').addEventListener('keypress', function (event) {
                                if (event.charCode < 48 || event.charCode > 57) {
                                    event.preventDefault();
                                }
                            });

                            document.getElementById('telefone').addEventListener('keypress', function (event) {
                                const allowedChars = [32, 40, 41, 45, 43];
                                if ((event.charCode < 48 || event.charCode > 57) && !allowedChars.includes(event.charCode)) {
                                    event.preventDefault();
                                }
                            });

                            document.getElementById('nome').addEventListener('keypress', function (event) {
                                const charCode = event.charCode;
                                if (!(charCode >= 48 && charCode <= 57) &&  
                                    !(charCode >= 65 && charCode <= 90) &&
                                    !(charCode >= 97 && charCode <= 122) &&
                                    charCode !== 32) {
                                    event.preventDefault();
                                }
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
