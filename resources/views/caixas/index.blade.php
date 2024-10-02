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

                    <!-- Exibe os caixas -->
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