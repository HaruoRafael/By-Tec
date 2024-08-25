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

                        <!-- Nome Completo -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-yellow-500">Nome Completo</label>
                            <input type="text" id="name" name="name" value="{{ $user->name }}" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-[#646cff] focus:ring-[#646cff] focus:ring-opacity-50 bg-white" readonly disabled>
                            @error('name')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- CPF e RG -->
                        <div class="flex flex-wrap -mx-2 mb-4">
                            <div class="w-full sm:w-1/2 px-2 mb-4 sm:mb-0">
                                <label for="cpf" class="block text-sm font-medium text-yellow-500">CPF</label>
                                <input type="text" id="cpf" name="cpf" value="{{ $user->cpf }}" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-[#646cff] focus:ring-[#646cff] focus:ring-opacity-50 bg-white" maxlength="14" readonly disabled>
                                @error('cpf')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full sm:w-1/2 px-2">
                                <label for="rg" class="block text-sm font-medium text-yellow-500">RG</label>
                                <input type="text" id="rg" name="rg" value="{{ $user->rg }}" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-[#646cff] focus:ring-[#646cff] focus:ring-opacity-50 bg-white" pattern="[0-9]*" inputmode="numeric" readonly disabled>
                                @error('rg')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Telefone e Sexo -->
                        <div class="flex flex-wrap -mx-2 mb-4">
                            <div class="w-full sm:w-1/2 px-2 mb-4 sm:mb-0">
                                <label for="telefone" class="block text-sm font-medium text-yellow-500">Telefone</label>
                                <input type="text" id="telefone" name="telefone" value="{{ $user->telefone }}" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-[#646cff] focus:ring-[#646cff] focus:ring-opacity-50 bg-white" pattern="[0-9]*" inputmode="numeric" readonly disabled>
                                @error('telefone')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full sm:w-1/2 px-2">
                                <label for="sexo" class="block text-sm font-medium text-yellow-500">Sexo</label>
                                <select id="sexo" name="sexo" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-[#646cff] focus:ring-[#646cff] focus:ring-opacity-50 bg-white" readonly disabled>
                                    <option value="masculino" {{ $user->sexo == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                    <option value="feminino" {{ $user->sexo == 'feminino' ? 'selected' : '' }}>Feminino</option>
                                    <option value="outro" {{ $user->sexo == 'outro' ? 'selected' : '' }}>Outro</option>
                                </select>
                                @error('sexo')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Data de Nascimento e Endereço -->
                        <div class="flex flex-wrap -mx-2 mb-4">
                            <div class="w-full sm:w-1/2 px-2 mb-4 sm:mb-0">
                                <label for="data_nascimento" class="block text-sm font-medium text-yellow-500">Data de Nascimento</label>
                                <input type="date" id="data_nascimento" name="data_nascimento" value="{{ $user->data_nascimento ? $user->data_nascimento->format('Y-m-d') : '' }}" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-[#646cff] focus:ring-[#646cff] focus:ring-opacity-50 bg-white" readonly disabled>
                                @error('data_nascimento')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full sm:w-1/2 px-2">
                                <label for="endereco" class="block text-sm font-medium text-yellow-500">Endereço</label>
                                <input type="text" id="endereco" name="endereco" value="{{ $user->endereco }}" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-[#646cff] focus:ring-[#646cff] focus:ring-opacity-50 bg-white" readonly disabled>
                                @error('endereco')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Cargo -->
                        <div class="mb-4">
                            <label for="cargo" class="block text-sm font-medium text-yellow-500">Cargo</label>
                            <select id="cargo" name="cargo" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-[#646cff] focus:ring-[#646cff] focus:ring-opacity-50 bg-white" readonly disabled>
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
                            <input type="email" id="email" name="email" value="{{ $user->email }}" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-[#646cff] focus:ring-[#646cff] focus:ring-opacity-50 bg-white" required readonly disabled>
                            @error('email')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Botões de Ação -->
                        <div class="flex justify-end space-x-2">
                            <button type="button" onclick="habilitarEdicao()" class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600">Editar</button>
                            <button type="submit" id="btnSalvar" style="display: none;" class="bg-green-500 text-white font-bold py-2 px-4 rounded hover:bg-green-600">Salvar</button>
                            <button type="button" id="btnCancelar" style="display: none;" onclick="cancelarEdicao()" class="bg-red-500 text-white font-bold py-2 px-4 rounded hover:bg-red-600">Cancelar</button>
                        </div>
                    </form>

                    <!-- Seção de Atualização de Senha -->
                    <h2 class="text-2xl font-bold mt-8 mb-4">Atualizar Senha</h2>
                    <form action="{{ route('password.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="current_password" class="block text-sm font-medium text-yellow-500">Senha Atual</label>
                            <input type="password" id="current_password" name="current_password" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-[#646cff] focus:ring-[#646cff] focus:ring-opacity-50 bg-white" required>
                            @error('current_password', 'updatePassword')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium text-yellow-500">Nova Senha</label>
                            <input type="password" id="password" name="password" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-[#646cff] focus:ring-[#646cff] focus:ring-opacity-50 bg-white" required>
                            @error('password', 'updatePassword')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="block text-sm font-medium text-yellow-500">Confirmar Nova Senha</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-[#646cff] focus:ring-[#646cff] focus:ring-opacity-50 bg-white" required>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-green-500 text-white font-bold py-2 px-4 rounded hover:bg-green-600">Atualizar Senha</button>
                        </div>
                    </form>

                    <!-- Botões de Reativação/Remoção -->
                    @if($user->status === 'Desativado')
                    <form id="formReativarFuncionario" action="{{ route('funcionarios.reativar', $user->id) }}" method="POST" class="mt-10">
                        @csrf
                        <button type="button" id="btnReativar" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-700" onclick="mostrarConfirmacaoReativacao()">Reativar</button>
                    </form>
                    @else
                    <form id="formRemoverFuncionario" action="{{ route('funcionarios.remove', $user->id) }}" method="POST" class="mt-10">
                        @csrf
                        @method('DELETE')
                        <button type="button" id="btnRemover" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-700" onclick="mostrarConfirmacao()">Remover</button>
                    </form>
                    @endif

                    <!-- Modais de Confirmação -->
                    <div id="confirmacaoModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
                        <div class="bg-black bg-opacity-50 absolute inset-0"></div>
                        <div class="bg-[#2d2d2d] p-6 rounded-md shadow-lg z-10">
                            <h3 class="text-lg text-yellow-500">Tem certeza que deseja remover este funcionário?</h3>
                            <div class="flex justify-end mt-4">
                                <button class="px-4 py-2 bg-gray-500 text-white rounded-md mr-2 hover:bg-gray-600" onclick="esconderConfirmacao()">Cancelar</button>
                                <button type="submit" form="formRemoverFuncionario" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">Remover</button>
                            </div>
                        </div>
                    </div>

                    <div id="confirmacaoReativacaoModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
                        <div class="bg-black bg-opacity-50 absolute inset-0"></div>
                        <div class="bg-[#2d2d2d] p-6 rounded-md shadow-lg z-10">
                            <h3 class="text-lg text-yellow-500">Tem certeza que deseja reativar este funcionário?</h3>
                            <div class="flex justify-end mt-4">
                                <button class="px-4 py-2 bg-gray-500 text-white rounded-md mr-2 hover:bg-gray-600" onclick="esconderConfirmacaoReativacao()">Cancelar</button>
                                <button type="submit" form="formReativarFuncionario" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">Reativar</button>
                            </div>
                        </div>
                    </div>

                    <!-- Scripts para exibir/ocultar modais e habilitar/desabilitar edição -->
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

                            document.getElementById('name').addEventListener('keypress', function (event) {
                                const charCode = event.charCode;
                                if (!(charCode >= 48 && charCode <= 57) &&  
                                    !(charCode >= 65 && charCode <= 90) &&
                                    !(charCode >= 97 && charCode <= 122) &&
                                    charCode !== 32) {
                                    event.preventDefault();
                                }
                            });

                            document.getElementById('btnSalvar').addEventListener('click', function () {
                                document.querySelector('form').submit();
                            });

                            document.getElementById('btnCancelar').addEventListener('click', function () {
                                cancelarEdicao();
                            });

                            document.getElementById('data_nascimento').addEventListener('change', function() {
                                var dataNascimento = new Date(this.value);
                                var dataAtual = new Date();
                                if (dataNascimento > dataAtual) {
                                    alert('A data de nascimento não pode ser no futuro.');
                                    this.value = '';
                                }
                            });

                            verificarErrosEhabilitarEdicao();
                        });

                        var valoresOriginais = {};

                        function verificarErrosEhabilitarEdicao() {
                            var errorMessages = document.querySelectorAll('.error-message');
                            if (errorMessages.length > 0) {
                                habilitarEdicao();
                            }
                        }

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

                        function mostrarConfirmacao() {
                            document.getElementById('confirmacaoModal').classList.remove('hidden');
                        }

                        function esconderConfirmacao() {
                            document.getElementById('confirmacaoModal').classList.add('hidden');
                        }

                        function mostrarConfirmacaoReativacao() {
                            document.getElementById('confirmacaoReativacaoModal').classList.remove('hidden');
                        }

                        function esconderConfirmacaoReativacao() {
                            document.getElementById('confirmacaoReativacaoModal').classList.add('hidden');
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
