<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-yellow-500 dark:text-yellow-500 leading-tight">
            {{ __('Lista de Planos') }}
        </h2>
        <x-nav-link :href="route('planos.create')" :active="request()->routeIs('planos.create')"
            class="text-yellow-500 hover:text-yellow-400">
            {{ __('Criar Plano') }}
        </x-nav-link>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#2d2d2d] overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-yellow-500 dark:text-yellow-500">
                    <div class="mb-4">
                        <form action="{{ route('planos.index') }}" method="GET" class="flex flex-col sm:flex-row sm:space-x-4">
                            <div class="flex flex-wrap sm:flex-nowrap sm:space-x-4">
                                <input type="text" id="termoPesquisa" name="termo" placeholder="Pesquisar por nome"
                                    value="{{ Request::input('termo') }}"
                                    class="block w-full mb-4 sm:mb-0 sm:w-auto text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">

                                <input type="number" id="valorPesquisa" name="valor" step="0.01" placeholder="Valor máximo (R$)"
                                    value="{{ Request::input('valor') }}"
                                    class="block w-full mb-4 sm:mb-0 sm:w-auto text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">

                                <input type="number" id="duracaoPesquisa" name="duracao" placeholder="Duração (meses)"
                                    value="{{ Request::input('duracao') }}"
                                    class="block w-full mb-4 sm:mb-0 sm:w-auto text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                            </div>
                            <div class="flex flex-wrap w-full sm:w-auto">
                                <button type="submit"
                                    class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600 mb-2 sm:mb-0 sm:mr-2">Pesquisar</button>
                                <a href="{{ route('planos.index') }}"
                                    class="bg-red-500 text-white font-bold py-2 px-4 rounded hover:bg-red-600 mb-2 sm:mb-0">Limpar Pesquisa</a>
                            </div>
                        </form>
                    </div>

                    @if($planos->isNotEmpty())
                    <div id="listaPlanosContainer">
                        <h2 class="text-xl font-bold mb-4">Lista de Planos</h2>
                        <table class="min-w-full bg-[#3d3d3d]">
                            <thead>
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs text-yellow-500 uppercase tracking-wider">
                                        Nome</th>
                                    <th class="px-4 py-3 text-left text-xs text-yellow-500 uppercase tracking-wider">
                                        Valor (R$)</th>
                                    <th class="px-4 py-3 text-left text-xs text-yellow-500 uppercase tracking-wider">
                                        Duração (meses)</th>
                                    <th class="px-4 py-3 text-left text-xs text-yellow-500 uppercase tracking-wider">
                                        Status</th>
                                    <th class="px-4 py-3 text-left text-xs text-yellow-500 uppercase tracking-wider">
                                        Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($planos as $plano)
                                <tr class="bg-[#3d3d3d] {{ !$plano->ativo ? 'text-red-500' : 'text-yellow-500' }}">
                                    <td class="px-4 py-4 whitespace-nowrap">{{ $plano->nome }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap">{{ number_format($plano->valor, 2, ',', '.') }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap">{{ $plano->duracao }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        {{ $plano->ativo ? 'Ativo' : 'Inativo' }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <a href="{{ route('planos.show', $plano->id) }}" class="text-blue-500 hover:text-blue-700">Ver</a>
                                        @if($plano->ativo)
                                        <form action="{{ route('planos.remove', $plano->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-red-500 hover:text-red-700 ml-2">Ocultar</button>
                                        </form>
                                        @else
                                        <form action="{{ route('planos.reativar', $plano->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-green-500 hover:text-green-700 ml-2">Reativar</button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p class="text-yellow-500">Nenhum plano encontrado.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>