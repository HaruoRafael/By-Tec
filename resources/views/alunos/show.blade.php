<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-yellow-500 dark:text-yellow-500 leading-tight">
            {{ __('Perfil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.6.0/cleave.min.js"></script>
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
                                    <label for="telefone"
                                        class="block text-sm font-medium text-yellow-500">Telefone</label>
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
                                    <input type="text" id="sexo" name="sexo" value="{{ old('sexo', $aluno->sexo) }}"
                                        class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                                        readonly disabled>
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
                                    <label for="endereco"
                                        class="block text-sm font-medium text-yellow-500">Endereço</label>
                                    <input type="text" id="endereco" name="endereco"
                                        value="{{ old('endereco', $aluno->endereco) }}"
                                        class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                                        readonly disabled>
                                    @error('endereco')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group flex flex-wrap mb-4">
                                <div class="w-full px-2">
                                    <label for="status" class="block text-sm font-medium text-yellow-500">Status</label>
                                    <select id="status" name="status"
                                        class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                                        disabled>
                                        <option value="Ativo" {{ old('status', $aluno->status) === 'Ativo' ? 'selected' : '' }}>Ativo</option>
                                        <option value="Inativo" {{ old('status', $aluno->status) === 'Inativo' ? 'selected' : '' }}>Inativo</option>
                                        <option value="Pendente" {{ old('status', $aluno->status) === 'Pendente' ? 'selected' : '' }}>Pendente</option>
                                        <option value="Removido" {{ old('status', $aluno->status) === 'Removido' ? 'selected' : '' }}>Removido</option>
                                    </select>
                                    @error('status')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex justify-end space-x-2">
                                <button type="button" onclick="habilitarEdicao()"
                                    class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700">Editar</button>
                                <button type="submit" id="btnSalvar" style="display: none;"
                                    class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-700">Salvar</button>
                                <button type="button" id="btnCancelar" style="display: none;" onclick="cancelarEdicao()"
                                    class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-700">Cancelar</button>
                            </div>
                        </form>

                        @if($aluno->status !== 'Removido')
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
                                    if ((event.charCode < 48 || event.charCode > 57) && event.charCode !== 32 && event.charCode !== 40 && event.charCode !== 41 && event.charCode !== 45 && event.charCode !== 43) {
                                        event.preventDefault();
                                    }
                                });

                                document.getElementById('data_nascimento').addEventListener('change', function () {
                                    var dataNascimento = new Date(this.value);
                                    var dataAtual = new Date();
                                    if (dataNascimento > dataAtual) {
                                        alert('A data de nascimento não pode ser no futuro.');
                                        this.value = '';
                                    }
                                });

                                var status = document.getElementById('status').value;
                                if (status === 'Removido') {
                                    document.getElementById('btnRemover').disabled = true;
                                }
                                verificarErrosEhabilitarEdicao();
                            });

                            function verificarErrosEhabilitarEdicao() {
                                var errorMessages = document.querySelectorAll('.error-message');
                                if (errorMessages.length > 0) {
                                    habilitarEdicao();
                                }
                            }

                            var valoresOriginais = {};

                            function habilitarEdicao() {
                                var campos = document.querySelectorAll('input[type="text"], input[type="date"], select');
                                campos.forEach(function (campo) {
                                    valoresOriginais[campo.id] = campo.value;
                                    campo.removeAttribute('readonly');
                                    campo.removeAttribute('disabled');
                                });
                                document.getElementById('btnSalvar').style.display = 'block';
                                document.getElementById('btnCancelar').style.display = 'inline-block';
                            }

                            function cancelarEdicao() {
                                var campos = document.querySelectorAll('input[type="text"], input[type="date"], select');
                                campos.forEach(function (campo) {
                                    campo.value = valoresOriginais[campo.id] || '';
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
                        </script>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-[#2d2d2d] overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-yellow-500 dark:text-yellow-500">
                        <h2 class="font-semibold text-xl text-yellow-500 dark:text-yellow-500 leading-tight">
                            {{ __('Avaliações') }}
                        </h2>
                        <button onclick="location.href='{{ route('avaliacao.create', $aluno->id) }}'"
                            class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700">
                            Criar Avaliação
                        </button>

                        @if($aluno->avaliacoes->isEmpty())
                            <p class="mt-4">Este aluno ainda não possui avaliações.</p>
                        @else
                            <table class="min-w-full bg-[#2d2d2d] mt-4">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs text-yellow-500 uppercase tracking-wider">
                                            Data</th>
                                        <th class="px-4 py-2 text-left text-xs text-yellow-500 uppercase tracking-wider">
                                            Avaliador</th>
                                        <th class="px-4 py-2 text-left text-xs text-yellow-500 uppercase tracking-wider">
                                            Detalhes</th>
                                        <th class="px-4 py-2 text-left text-xs text-yellow-500 uppercase tracking-wider">
                                            Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($aluno->avaliacoes as $avaliacao)
                                        <tr id="avaliacao-{{ $avaliacao->id }}" class="bg-[#2d2d2d]">
                                            <td class="border px-4 py-2 text-yellow-500">{{ $avaliacao->data }}</td>
                                            <td class="border px-4 py-2 text-yellow-500">{{ $avaliacao->avaliador }}</td>
                                            <td class="border px-4 py-2 text-yellow-500">
                                                <a href="{{ route('avaliacao.show', $avaliacao->id) }}"
                                                    class="text-blue-500 hover:underline">Ver detalhes</a>
                                            </td>
                                            <td class="border px-4 py-2 text-yellow-500">
                                                <button type="button"
                                                    class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-700"
                                                    onclick="removerAvaliacao({{ $avaliacao->id }})">Remover</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        function removerAvaliacao(id) {
            if (confirm('Tem certeza que deseja remover esta avaliação?')) {
                axios.delete(`/avaliacoes/${id}`)
                    .then(response => {
                        location.reload(); // Recarrega a página após excluir
                    })
                    .catch(error => {
                        console.error('Erro ao remover avaliação:', error);
                    });
            }
        }
    </script>
</x-app-layout>
