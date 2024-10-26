<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-yellow-500 dark:text-yellow-500 leading-tight">
            {{ __('Caixas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#2d2d2d] overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-yellow-500 dark:text-yellow-500">
                    <h2 class="text-2xl font-bold mb-4">Lista de Caixas</h2>

                    <form action="{{ route('caixas.index') }}" method="GET" class="mb-4">
                        <label for="status" class="mr-2">Filtrar por Status:</label>
                        <select name="status" id="status" class="border p-3 rounded-md bg-[#2d2d2d] text-yellow-500 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                            <option value="" class="text-gray-500">Todos</option>
                            <option value="aberto" {{ request('status') == 'aberto' ? 'selected' : '' }}>Aberto</option>
                            <option value="fechado" {{ request('status') == 'fechado' ? 'selected' : '' }}>Fechado</option>
                        </select>

                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded ml-2">Pesquisar</button>
                    </form>
                    @if (session('error'))
                    <div class="bg-red-500 text-white p-4 rounded mb-4">
                        {{ session('error') }}
                    </div>
                    @endif

                    @if (session('success'))
                    <div class="bg-green-500 text-white p-4 rounded mb-4">
                        {{ session('success') }}
                    </div>
                    @endif
                    <table class="min-w-full bg-[#2d2d2d]">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">ID</th>
                                <th class="px-4 py-2">Abertura</th>
                                <th class="px-4 py-2">Fechamento</th>
                                <th class="px-4 py-2">Status</th>
                                <th class="px-4 py-2">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($caixas as $caixa)
                            <tr>
                                <td class="border px-4 py-2">{{ $caixa->id }}</td>
                                <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($caixa->data_abertura)->format('d/m/Y H:i') }}</td>
                                <td class="border px-4 py-2">{{ $caixa->data_fechamento ? \Carbon\Carbon::parse($caixa->data_fechamento)->format('d/m/Y H:i') : 'Em aberto' }}</td>
                                <td class="border px-4 py-2">{{ $caixa->status }}</td>
                                <td class="border px-4 py-2">
                                    <a href="{{ route('caixas.show', $caixa->id) }}" class="text-blue-500 hover:underline">Ver</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        <a href="{{ route('caixas.create') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Abrir Novo Caixa</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>