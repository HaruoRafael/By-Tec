<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-yellow-500 leading-tight">
            {{ __('Detalhes da Venda') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#2d2d2d] overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-yellow-500 border-b border-gray-700">
                    <h3 class="text-lg font-semibold text-yellow-500">Venda #{{ $venda->id }}</h3>

                    <p><strong>Aluno:</strong> {{ $venda->aluno->nome }}</p>
                    <p><strong>Plano:</strong> {{ $venda->plano->nome }}</p>
                    <p><strong>Valor:</strong> R$ {{ number_format($venda->valor, 2, ',', '.') }}</p>
                    <p><strong>Forma de Pagamento:</strong> {{ ucfirst($venda->forma_pagamento) }}</p>
                    <p><strong>Data da Venda:</strong> {{ \Carbon\Carbon::parse($venda->data)->format('d/m/Y') }}</p>
                    <p><strong>Data de Início:</strong> {{ \Carbon\Carbon::parse($venda->data_inicio)->format('d/m/Y') }}</p>
                    <p><strong>Data de Expiração:</strong> {{ \Carbon\Carbon::parse($venda->data_expiracao)->format('d/m/Y') }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($venda->status) }}</p>
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
