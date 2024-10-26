<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-yellow-500 dark:text-yellow-500 leading-tight">
            {{ __('Lista de Exercícios') }}
        </h2>
        <x-nav-link :href="route('exercicios.create')" :active="request()->routeIs('exercicios.create')"
            class="text-yellow-500 hover:text-yellow-400">
            {{ __('Criar Exercício') }}
        </x-nav-link>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#2d2d2d] overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-yellow-500 dark:text-yellow-500">
                    <div class="mb-4">
                        <form action="{{ route('exercicios.index') }}" method="GET" class="flex flex-col sm:flex-row sm:space-x-4">
                            <div class="flex items-center mb-4 sm:mb-0">
                                @foreach(['easy' => 'Fácil', 'normal' => 'Normal', 'hard' => 'Difícil'] as $key => $value)
                                <div class="flex items-center mr-4">
                                    <input type="checkbox" id="{{ $key }}" name="dificuldade[]" value="{{ $key }}" {{ in_array($key, Request::input('dificuldade', [])) ? 'checked' : '' }} class="text-yellow-500 border-gray-300 rounded focus:ring-yellow-500">
                                    <label for="{{ $key }}" class="ml-2 text-sm text-yellow-500">{{ $value }}</label>
                                </div>
                                @endforeach
                            </div>
                            <div class="flex flex-wrap sm:flex-nowrap sm:space-x-4">
                                <input type="text" id="termoPesquisa" name="termo" placeholder="Pesquisar por nome" value="{{ Request::input('termo') }}" class="block w-full mb-4 sm:mb-0 sm:w-auto text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                                <input type="text" id="grupoMuscularPesquisa" name="grupo_muscular" placeholder="Grupo muscular" value="{{ Request::input('grupo_muscular') }}" class="block w-full mb-4 sm:mb-0 sm:w-auto text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                            </div>
                            <div class="flex flex-wrap w-full sm:w-auto">
                                <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600 mb-2 sm:mb-0 sm:mr-2">Pesquisar</button>
                                <a href="{{ route('exercicios.index') }}" class="bg-red-500 text-white font-bold py-2 px-4 rounded hover:bg-red-600 mb-2 sm:mb-0">Limpar Pesquisa</a>
                            </div>
                        </form>
                    </div>

                    @if($exercicios->isNotEmpty())
                    <div id="listaExerciciosContainer">
                        <h2 class="text-xl font-bold mb-4">Lista de Exercícios</h2>
                        <table class="min-w-full bg-[#3d3d3d]">
                            <thead>
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs text-yellow-500 uppercase tracking-wider">Nome</th>
                                    <th class="px-4 py-3 text-left text-xs text-yellow-500 uppercase tracking-wider">Grupo Muscular</th>
                                    <th class="px-4 py-3 text-left text-xs text-yellow-500 uppercase tracking-wider">Dificuldade</th>
                                    <th class="px-4 py-3 text-left text-xs text-yellow-500 uppercase tracking-wider">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($exercicios as $exercicio)
                                <tr class="bg-[#3d3d3d]">
                                    <td class="px-4 py-4 text-yellow-500 whitespace-nowrap">{{ $exercicio->nome }}</td>
                                    <td class="px-4 py-4 text-yellow-500 whitespace-nowrap">{{ $exercicio->grupo_muscular }}</td>
                                    <td class="px-4 py-4 text-yellow-500 whitespace-nowrap">{{ ucfirst($exercicio->dificuldade == 'easy' ? 'Fácil' : ($exercicio->dificuldade == 'normal' ? 'Normal' : 'Difícil')) }}</td>
                                    <td class="px-4 py-4 text-yellow-500 whitespace-nowrap">
                                        <a href="{{ route('exercicios.show', $exercicio->id) }}" class="text-blue-500 hover:text-blue-700">Ver</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-6">
                            <nav role="navigation" aria-label="Pagination Navigation" class="inline-flex rounded-md shadow">
                                {{ $exercicios->appends(request()->query())->links('pagination::tailwind') }}
                            </nav>
                        </div>
                    </div>
                    @else
                    <p class="text-yellow-500">Nenhum exercício encontrado.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>