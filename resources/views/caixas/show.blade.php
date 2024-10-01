<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-yellow-500 dark:text-yellow-500 leading-tight">
            {{ __('Detalhes do Caixa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#2d2d2d] overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-yellow-500 dark:text-yellow-500">
                    <h2 class="text-2xl font-bold mb-4">Caixa #{{ $caixa->id }}</h2>

                    <p><strong>Data de Abertura:</strong> {{ $caixa->data_abertura }}</p>
                    <p><strong>Data de Fechamento:</strong> {{ $caixa->data_fechamento ?? 'Em aberto' }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($caixa->status) }}</p>
                    <p><strong>Saldo Inicial:</strong> R$ {{ number_format($caixa->saldo_inicial, 2, ',', '.') }}</p>

                    <!-- Cálculo do saldo final levando em consideração as vendas ativas -->
                    @php
                        $totalVendasAtivas = $vendas->where('status', 'Ativo')->sum('valor');
                        $saldoCalculado = $caixa->saldo_inicial + $totalVendasAtivas;
                    @endphp

                    <p><strong>Saldo Calculado (Com Vendas):</strong> R$ {{ number_format($saldoCalculado, 2, ',', '.') }}</p>

                    <h3 class="text-xl font-bold mt-4">Vendas</h3>
                    @if($vendas->isEmpty())
                        <p>Nenhuma venda registrada neste caixa.</p>
                    @else
                        <table class="min-w-full bg-[#2d2d2d] mt-4">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">Descrição</th>
                                    <th class="px-4 py-2">Valor</th>
                                    <th class="px-4 py-2">Data</th>
                                    <th class="px-4 py-2">Forma de Pagamento</th>
                                    <th class="px-4 py-2">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($vendas as $venda)
                                    <tr>
                                        <td class="border px-4 py-2">
                                            <!-- Link para detalhes da venda -->
                                            <a href="{{ route('vendas.show', $venda->id) }}" class="text-blue-500 hover:underline">
                                                {{ $venda->descricao }}
                                            </a>
                                        </td>
                                        <td class="border px-4 py-2">R$ {{ number_format($venda->valor, 2, ',', '.') }}</td>
                                        <td class="border px-4 py-2">{{ $venda->data }}</td>
                                        <td class="border px-4 py-2">{{ ucfirst($venda->forma_pagamento) }}</td>
                                        <td class="border px-4 py-2">
                                            @if($venda->status == 'Ativo')
                                                <!-- Botão de Reembolso -->
                                                <form action="{{ route('vendas.reembolsar', $venda->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="bg-yellow-500 text-black font-bold py-1 px-3 rounded hover:bg-yellow-600">Reembolsar</button>
                                                </form>
                                            @else
                                                <span class="text-gray-500">Não disponível</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                    @if($caixa->status == 'aberto')
                        <form action="{{ route('caixas.fechar', $caixa->id) }}" method="POST" class="mt-4">
                            @csrf
                            <div class="form-group mb-4">
                                <label for="saldo_final" class="block text-sm font-medium text-yellow-500">Saldo Final</label>
                                <input type="number" step="0.01" id="saldo_final" name="saldo_final" value="{{ number_format($saldoCalculado, 2, '.', '') }}" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" required>
                            </div>
                            <button type="submit" class="bg-red-500 text-white font-bold py-2 px-4 rounded hover:bg-red-600">Fechar Caixa</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
