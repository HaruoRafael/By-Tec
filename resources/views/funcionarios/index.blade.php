<!-- resources/views/funcionarios/index.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-yellow-500 dark:text-yellow-500 leading-tight">
            {{ __('Lista de Funcionários') }}
        </h2>
        <x-nav-link :href="route('funcionarios.create')" :active="request()->routeIs('funcionarios.create')" class="text-yellow-500 hover:text-yellow-400">
            {{ __('Cadastrar Funcionário') }}
        </x-nav-link>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#2d2d2d] overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-yellow-500 dark:text-yellow-500">
                    <div class="mb-6">
                        <form action="{{ route('funcionarios.index') }}" method="GET" class="flex flex-col sm:flex-row sm:space-x-4">

                            <div class="flex flex-wrap sm:flex-nowrap sm:space-x-4">
                                <input type="text" id="termoPesquisa" name="termo" placeholder="Pesquisar por nome" value="{{ Request::input('termo') }}" class="block w-full mb-4 sm:mb-0 sm:w-auto text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                                <input type="text" id="cpfPesquisa" name="cpf" placeholder="Pesquisar por CPF" value="{{ Request::input('cpf') }}" class="block w-full mb-4 sm:mb-0 sm:w-auto text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                            </div>
                            <div class="flex space-x-4">
                                <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600">Pesquisar</button>
                                <a href="{{ route('funcionarios.index') }}" class="bg-red-500 text-white font-bold py-2 px-4 rounded hover:bg-red-600">Limpar Pesquisa</a>
                            </div>
                        </form>
                    </div>

                    @if(isset($funcionarios) && $funcionarios->count() > 0)
                        <div id="listaFuncionariosContainer">
                            <h2 class="text-xl font-bold mb-4">Lista de Funcionários</h2>
                            <table class="min-w-full bg-[#3d3d3d]">
                                <thead>
                                    <tr>
                                        <th class="px-5 py-3 text-left text-xs text-yellow-500 uppercase tracking-wider">Nome</th>
                                        <th class="px-5 py-3 text-left text-xs text-yellow-500 uppercase tracking-wider">Cargo</th>
                                        <th class="px-5 py-3 text-left text-xs text-yellow-500 uppercase tracking-wider">Idade</th>
                                        <th class="px-5 py-3 text-left text-xs text-yellow-500 uppercase tracking-wider">Sexo</th>
                                        <th class="px-5 py-3 text-left text-xs text-yellow-500 uppercase tracking-wider">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($funcionarios as $funcionario)
                                        <tr class="bg-[#3d3d3d]qw">
                                            <td class="px-5 py-4 text-yellow-500 whitespace-nowrap">{{ $funcionario->name }}</td>
                                            <td class="px-5 py-4 text-yellow-500 whitespace-nowrap">{{ $funcionario->cargo }}</td>
                                            <td class="px-5 py-4 text-yellow-500 whitespace-nowrap">{{ $funcionario->data_nascimento ? \Carbon\Carbon::parse($funcionario->data_nascimento)->age : 'N/A' }}</td>
                                            <td class="px-5 py-4 text-yellow-500 whitespace-nowrap">{{ $funcionario->sexo }}</td>
                                            <td class="px-5 py-4 text-yellow-500 whitespace-nowrap">
                                                <a href="{{ route('funcionarios.show', $funcionario->id) }}" class="text-blue-500 hover:text-blue-700">Ver</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-yellow-500">Nenhum funcionário encontrado.</p>
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
