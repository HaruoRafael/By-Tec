<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalhes da Venda') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold">Venda #{{ $venda->id }}</h3>

                    <p><strong>Aluno:</strong> {{ $venda->aluno->nome }}</p>
                    <p><strong>Plano:</strong> {{ $venda->plano->nome }}</p>
                    <p><strong>Valor:</strong> R$ {{ number_format($venda->valor, 2, ',', '.') }}</p>
                    <p><strong>Forma de Pagamento:</strong> {{ ucfirst($venda->forma_pagamento) }}</p>
                    <p><strong>Data da Venda:</strong> {{ \Carbon\Carbon::parse($venda->data)->format('d/m/Y') }}</p>
                    <p><strong>Data de Expiração:</strong> {{ \Carbon\Carbon::parse($venda->data_expiracao)->format('d/m/Y') }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($venda->status) }}</p>

                    <!-- Link para voltar ao perfil do aluno -->
                    <a href="{{ route('alunos.show', $venda->aluno_id) }}" class="text-blue-500 hover:underline">
                        Voltar para o perfil do aluno
                    </a>
                    <p></p>
                    <a href="{{ route('caixas.show', $venda->caixa_id) }}" class="text-blue-500 hover:underline">
                        Voltar para o caixa
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>