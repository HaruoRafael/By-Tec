<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="bg-[#2d2d2d] overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-yellow-500 dark:text-yellow-500">
                <h2 class="text-2xl font-bold mb-4">Informações do Aluno</h2>

                @if(session('success'))
                <div class="bg-green-500 text-white p-4 rounded mb-4">{{ session('success') }}</div>
                @endif

                @if(session('warning'))
                <div class="bg-yellow-500 text-white p-4 rounded mb-4">{{ session('warning') }}</div>
                @endif

                <form id="formEditarAluno" action="{{ route('alunos.update', $aluno->id) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="form-group flex flex-wrap mb-4">
                        <div class="w-full sm:w-1/2 px-2">
                            <label for="nome" class="block text-sm font-medium text-yellow-500">Nome*</label>
                            <input type="text" id="nome" name="nome" value="{{ old('nome', $aluno->nome) }}"
                                class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                                readonly disabled>
                            @error('nome')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="w-full sm:w-1/2 px-2">
                            <label for="cpf" class="block text-sm font-medium text-yellow-500">CPF*</label>
                            <input type="text" id="cpf" name="cpf" value="{{ old('cpf', $aluno->cpf) }}"
                                class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                                maxlength="14" readonly disabled>
                            @error('cpf')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group flex flex-wrap mb-4">
                        <div class="w-full sm:w-1/2 px-2">
                            <label for="rg" class="block text-sm font-medium text-yellow-500">RG</label>
                            <input type="text" id="rg" name="rg" value="{{ old('rg', $aluno->rg) }}"
                                class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                                pattern="[0-9]*" inputmode="numeric" readonly disabled>
                            @error('rg')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="w-full sm:w-1/2 px-2">
                            <label for="telefone" class="block text-sm font-medium text-yellow-500">Telefone</label>
                            <input type="text" id="telefone" name="telefone"
                                value="{{ old('telefone', $aluno->telefone) }}"
                                class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                                pattern="[0-9]*" inputmode="numeric" readonly disabled>
                            @error('telefone')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group flex flex-wrap mb-4">
                        <div class="w-full sm:w-1/2 px-2">
                            <label for="sexo" class="block text-sm font-medium text-yellow-500">Sexo</label>
                            <select id="sexo" name="sexo" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" disabled>
                                <option value="Masculino" {{ old('sexo', $aluno->sexo) == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                <option value="Feminino" {{ old('sexo', $aluno->sexo) == 'Feminino' ? 'selected' : '' }}> Feminino</option>
                                <option value="Outro" {{ old('sexo', $aluno->sexo) == 'Outro' ? 'selected' : '' }}>Outro
                                </option>
                            </select>
                            @error('sexo')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="w-full sm:w-1/2 px-2">
                            <label for="data_nascimento" class="block text-sm font-medium text-yellow-500">Data
                                de Nascimento*</label>
                            <input type="date" id="data_nascimento" name="data_nascimento"
                                value="{{ old('data_nascimento', $aluno->data_nascimento) }}"
                                class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                                readonly disabled>
                            @error('data_nascimento')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group flex flex-wrap mb-4">
                        <div class="w-full px-2">
                            <label for="endereco" class="block text-sm font-medium text-yellow-500">Endereço</label>
                            <input type="text" id="endereco" name="endereco"
                                value="{{ old('endereco', $aluno->endereco) }}"
                                class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                                readonly disabled>
                            @error('endereco')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>



                    <div class="flex justify-end space-x-2">
                        @if(Auth::user()->cargo !== 'Professor')
                        <button type="button" onclick="habilitarEdicao()"
                            class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700">Editar</button>
                        <button type="submit" id="btnSalvar" style="display: none;"
                            class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-700">Salvar</button>
                        <button type="button" id="btnCancelar" style="display: none;" onclick="cancelarEdicao()"
                            class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-700">Cancelar</button>
                        @endif
                    </div>
                </form>

                @if($aluno->status === 'Removido' && Auth::user()->cargo !== 'Professor')
                <form id="formReativarAluno" action="{{ route('alunos.reativar', $aluno->id) }}" method="POST"
                    class="mt-10">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-700">
                        Reativar Aluno
                    </button>
                </form>
                @endif

                @if($aluno->status !== 'Removido' && Auth::user()->cargo !== 'Professor')
                <form id="formRemoverAluno" action="{{ route('alunos.remove', $aluno->id) }}" method="POST"
                    class="mt-10">
                    @csrf
                    @method('DELETE')
                    <button type="button" id="btnRemover"
                        class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-700"
                        onclick="mostrarConfirmacao()">Remover</button>
                </form>
                @endif

                <div id="confirmacaoModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
                    <div class="bg-black bg-opacity-50 absolute inset-0"></div>
                    <div class="bg-[#2d2d2d] p-6 rounded-md shadow-lg z-10">
                        <h3 class="text-lg text-yellow-500">Tem certeza que deseja remover este aluno?</h3>
                        <div class="flex justify-end mt-4">
                            <button class="px-4 py-2 bg-gray-500 text-white rounded-md mr-2 hover:bg-gray-600"
                                onclick="esconderConfirmacao()">Cancelar</button>
                            <button type="submit" form="formRemoverAluno"
                                class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">Remover</button>
                        </div>
                    </div>
                </div>


                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        aplicarMascaras();
                        configurarValidacoes();
                        verificarStatusAluno();
                        verificarErrosEhabilitarEdicao();
                    });

                    /**
                     * Aplica máscaras de formatação nos campos especificados
                     */
                    function aplicarMascaras() {
                        // Máscara para o campo CPF
                        if (document.getElementById('cpf')) {
                            new Cleave('#cpf', {
                                delimiters: ['.', '.', '-'],
                                blocks: [3, 3, 3, 2],
                                numericOnly: true
                            });
                        }
                    }

                    /**
                     * Configura validações nos campos de RG, telefone e data de nascimento
                     */
                    function configurarValidacoes() {
                        // Validação para o campo RG (somente números)
                        var rgField = document.getElementById('rg');
                        if (rgField) {
                            rgField.addEventListener('keypress', function(event) {
                                if (event.charCode < 48 || event.charCode > 57) {
                                    event.preventDefault();
                                }
                            });
                        }

                        // Validação para o campo telefone (números e caracteres permitidos)
                        var telefoneField = document.getElementById('telefone');
                        if (telefoneField) {
                            telefoneField.addEventListener('keypress', function(event) {
                                const allowedChars = [32, 40, 41, 45, 43];
                                if ((event.charCode < 48 || event.charCode > 57) && !allowedChars.includes(event.charCode)) {
                                    event.preventDefault();
                                }
                            });
                        }

                        // Validação para o campo data de nascimento (não permite datas futuras)
                        var dataNascimentoField = document.getElementById('data_nascimento');
                        if (dataNascimentoField) {
                            dataNascimentoField.addEventListener('change', function() {
                                var dataNascimento = new Date(this.value);
                                var dataAtual = new Date();
                                if (dataNascimento > dataAtual) {
                                    alert('A data de nascimento não pode ser no futuro.');
                                    this.value = '';
                                }
                            });
                        }
                    }

                    /**
                     * Verifica o status do aluno e desabilita o botão de remoção se o aluno estiver "Removido"
                     */
                    function verificarStatusAluno() {
                        var status = document.getElementById('status');
                        if (status && status.value === 'Removido') {
                            var btnRemover = document.getElementById('btnRemover');
                            if (btnRemover) {
                                btnRemover.disabled = true;
                            }
                        }
                    }

                    /**
                     * Verifica se há mensagens de erro e habilita a edição se necessário
                     */
                    function verificarErrosEhabilitarEdicao() {
                        var errorMessages = document.querySelectorAll('.error-message');
                        if (errorMessages.length > 0) {
                            habilitarEdicao();
                        }
                    }

                    var valoresOriginais = {};

                    /**
                     * Habilita o modo de edição dos campos
                     */
                    function habilitarEdicao() {
                        var campos = document.querySelectorAll('input[type="text"], input[type="date"], select');
                        campos.forEach(function(campo) {
                            valoresOriginais[campo.id] = campo.value;
                            campo.removeAttribute('readonly');
                            campo.removeAttribute('disabled');
                        });
                        mostrarBotoesSalvarCancelar();
                    }

                    /**
                     * Cancela o modo de edição e restaura os valores originais dos campos
                     */
                    function cancelarEdicao() {
                        var campos = document.querySelectorAll('input[type="text"], input[type="date"], select');
                        campos.forEach(function(campo) {
                            campo.value = valoresOriginais[campo.id] || '';
                            campo.setAttribute('readonly', true);
                            campo.setAttribute('disabled', true);
                        });
                        esconderBotoesSalvarCancelar();
                    }

                    /**
                     * Exibe os botões "Salvar" e "Cancelar"
                     */
                    function mostrarBotoesSalvarCancelar() {
                        document.getElementById('btnSalvar').style.display = 'block';
                        document.getElementById('btnCancelar').style.display = 'inline-block';
                    }

                    /**
                     * Esconde os botões "Salvar" e "Cancelar"
                     */
                    function esconderBotoesSalvarCancelar() {
                        document.getElementById('btnSalvar').style.display = 'none';
                        document.getElementById('btnCancelar').style.display = 'none';
                    }

                    /**
                     * Exibe o modal de confirmação para remover o aluno
                     */
                    function mostrarConfirmacao() {
                        document.getElementById('confirmacaoModal').classList.remove('hidden');
                    }

                    /**
                     * Esconde o modal de confirmação para remover o aluno
                     */
                    function esconderConfirmacao() {
                        document.getElementById('confirmacaoModal').classList.add('hidden');
                    }~
                    document.getElementById('nome').addEventListener('keypress', function(event) {
                        const charCode = event.charCode || event.keyCode;
                        const char = String.fromCharCode(charCode);

                        const allowed = /^[a-zA-ZÀ-ÿ\s]+$/;

                        if (!allowed.test(char)) {
                            event.preventDefault();
                        }
                    });
                </script>
            </div>
        </div>
    </div>
</div>