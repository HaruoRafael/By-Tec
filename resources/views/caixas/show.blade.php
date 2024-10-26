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
                    <div class="p-6 rounded-lg shadow-md text-yellow-500">
                        <h2 class="text-3xl font-bold mb-6 border-b border-yellow-500 pb-4">Detalhes do Caixa #{{ $caixa->id }}</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <p class="flex items-center"><strong class="mr-2">Data de Abertura:</strong>
                                    <span class="ml-auto">{{ \Carbon\Carbon::parse($caixa->data_abertura)->format('d/m/Y H:i') }}</span>
                                </p>
                            </div>

                            <div>
                                <p class="flex items-center"><strong class="mr-2">Data de Fechamento:</strong>
                                    <span class="ml-auto">
                                        {{ $caixa->data_fechamento ? \Carbon\Carbon::parse($caixa->data_fechamento)->format('d/m/Y H:i') : 'Em aberto' }}
                                    </span>
                                </p>
                            </div>

                            <div>
                                <p class="flex items-center"><strong class="mr-2">Status:</strong>
                                    <span class="ml-auto">{{ ucfirst($caixa->status) }}</span>
                                </p>
                            </div>

                            <div>
                                <p class="flex items-center"><strong class="mr-2">Saldo Inicial:</strong>
                                    <span class="ml-auto">R$ {{ number_format($caixa->saldo_inicial, 2, ',', '.') }}</span>
                                </p>
                            </div>
                        </div>

                        @php
                        $totalVendasAtivasOuFinalizadas = $vendas->whereIn('status', ['Ativo', 'Finalizado'])->sum('valor');
                        $saldoCalculado = $caixa->saldo_inicial + $totalVendasAtivasOuFinalizadas;
                        @endphp

                        <p class="mt-6"><strong>Saldo Calculado (Com Vendas):</strong> R$ {{ number_format($saldoCalculado, 2, ',', '.') }}</p>

                        <h3 class="text-xl font-bold mt-6">Vendas</h3>
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
                                        <a href="{{ route('vendas.show', $venda->id) }}" class="text-blue-500 hover:underline">
                                            {{ $venda->descricao }}
                                        </a>
                                    </td>
                                    <td class="border px-4 py-2">R$ {{ number_format($venda->valor, 2, ',', '.') }}</td>
                                    <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($venda->created_at)->format('d/m/Y H:i') }}</td>
                                    <td class="border px-4 py-2">{{ ucfirst($venda->forma_pagamento) }}</td>
                                    <td class="border px-4 py-2">
                                        @if($venda->status == 'Ativo')
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
                        <form action="{{ route('caixas.fechar', $caixa->id) }}" method="POST" class="mt-6">
                            @csrf
                            <button type="submit" class="bg-red-500 text-white font-bold py-2 px-4 rounded hover:bg-red-600">Fechar Caixa</button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>