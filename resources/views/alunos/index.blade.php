<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-yellow-500 dark:text-yellow-500 leading-tight">
            {{ __('Lista de Alunos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#2d2d2d] overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-yellow-500 dark:text-yellow-500">
                    <div class="mb-6">
                        <form action="{{ route('alunos.index') }}" method="GET"
                            class="flex flex-col sm:flex-row sm:space-x-4">
                            <div class="flex items-center mb-4 sm:mb-0">
                                @foreach(['Ativo', 'Inativo', 'Pendente', 'Removido'] as $status)
                                    <div class="flex items-center mr-4">
                                        <input type="checkbox" id="{{ strtolower($status) }}" name="status[]"
                                            value="{{ $status }}" {{ in_array($status, Request::input('status', [])) ? 'checked' : '' }}
                                            class="text-yellow-500 border-gray-300 rounded focus:ring-yellow-500">
                                        <label for="{{ strtolower($status) }}"
                                            class="ml-2 text-sm text-yellow-500">{{ $status }}</label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="flex flex-wrap sm:flex-nowrap sm:space-x-4">
                                <input type="text" id="termoPesquisa" name="termo" placeholder="Pesquisar por nome"
                                    value="{{ Request::input('termo') }}"
                                    class="block w-full mb-4 sm:mb-0 sm:w-auto text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                                <input type="text" id="cpfPesquisa" name="cpf" placeholder="Pesquisar por CPF"
                                    value="{{ Request::input('cpf') }}"
                                    class="block w-full mb-4 sm:mb-0 sm:w-auto text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                            </div>
                            <div class="flex flex-wrap w-full sm:w-auto">
                                <button type="submit"
                                    class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600 mb-2 sm:mb-0 sm:mr-2">Pesquisar</button>
                                <a href="{{ route('alunos.index') }}"
                                    class="bg-red-500 text-white font-bold py-2 px-4 rounded hover:bg-red-600 mb-2 sm:mb-0">Limpar
                                    Pesquisa</a>
                            </div>
                        </form>
                    </div>

                    @if(isset($alunos) && $alunos->count() > 0)
                        <div id="listaAlunosContainer" class="overflow-x-auto">
                            <h2 class="text-xl font-semibold text-yellow-500 mb-4">Lista de Alunos</h2>
                            <table class="min-w-full table-auto bg-[#3d3d3d] border-collapse border border-[#3d3d3d]">
                                <thead>
                                    <tr>
                                        <th
                                            class="px-5 py-3 text-left text-xs text-yellow-500 uppercase tracking-wider border-b border-yellow-500">
                                            Nome</th>
                                        <th
                                            class="px-5 py-3 text-left text-xs text-yellow-500 uppercase tracking-wider border-b border-yellow-500">
                                            Idade</th>
                                        <th
                                            class="px-5 py-3 text-left text-xs text-yellow-500 uppercase tracking-wider border-b border-yellow-500">
                                            Sexo</th>
                                        <th
                                            class="px-5 py-3 text-left text-xs text-yellow-500 uppercase tracking-wider border-b border-yellow-500">
                                            Status</th>
                                        <th
                                            class="px-5 py-3 text-left text-xs text-yellow-500 uppercase tracking-wider border-b border-yellow-500">
                                            Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($alunos as $aluno)
                                        <tr
                                            class="{{ $aluno->status == 'Removido' ? 'bg-red-500 text-red-100' : 'bg-[#3d3d3d] text-yellow-500' }} hover:bg-[#4a4a4a] transition-colors duration-200">
                                            <td class="px-5 py-4 whitespace-nowrap border-b border-[#4a4a4a]">{{ $aluno->nome }}
                                            </td>
                                            <td class="px-5 py-4 whitespace-nowrap border-b border-[#4a4a4a]">
                                                {{ $aluno->idade }}</td>
                                            <td class="px-5 py-4 whitespace-nowrap border-b border-[#4a4a4a]">{{ $aluno->sexo }}
                                            </td>
                                            <td class="px-5 py-4 whitespace-nowrap border-b border-[#4a4a4a]">
                                                {{ $aluno->status }}</td>
                                            <td class="px-5 py-4 whitespace-nowrap border-b border-[#4a4a4a]">
                                                <a href="{{ route('alunos.show', $aluno->id) }}"
                                                    class="text-blue-500 hover:text-blue-700 transition-colors duration-200">Ver</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- Paginação -->
                            <div class="mt-4">
                                {{ $alunos->links() }}
                            </div>
                        </div>
                    @else
                        <p class="text-yellow-500">Nenhum aluno encontrado.</p>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <!-- Script para formatação de campos e validações -->
    <script src="https://cdn.jsdelivr.net/npm/cleave.js@1.6.0/dist/cleave.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            new Cleave('#cpfPesquisa', {
                delimiters: ['.', '.', '-'],
                blocks: [3, 3, 3, 2],
                numericOnly: true
            });
        });
    </script>
</x-app-layout>
