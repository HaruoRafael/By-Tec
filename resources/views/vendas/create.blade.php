<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-yellow-500 dark:text-yellow-500 leading-tight">
            {{ __('Venda') }}
        </h2>
        <button onclick="history.back()" class="text-yellow-500 hover:text-yellow-400">
            Voltar
        </button>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#2d2d2d] overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-yellow-500 dark:text-yellow-500">
                    @if(session('error'))
                    <div class="bg-red-500 text-white p-4 rounded mb-4">
                        {{ session('error') }}
                    </div>
                    @endif
                    <h2 class="text-2xl font-bold mb-4">Vender Plano</h2>
                    <form action="{{ route('vendas.store') }}" method="POST" id="vendaForm">
                        @csrf
                        <input type="hidden" name="aluno_id" value="{{ $aluno->id }}">

                        <div class="form-group flex flex-wrap mb-4">
                            <div class="w-full sm:w-1/2 px-2">
                                <label for="descricao" class="block text-sm font-medium text-yellow-500">Descrição*</label>
                                <input type="text" id="descricao" name="descricao" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-[#646cff] focus:ring-[#646cff] focus:ring-opacity-50" required>
                            </div>

                            <div class="w-full sm:w-1/2 px-2">
                                <label for="data_inicio" class="block text-sm font-medium text-yellow-500">Data de Início do Plano</label>
                                <input type="date" id="data_inicio" name="data_inicio" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-[#646cff] focus:ring-[#646cff] focus:ring-opacity-50" value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>

                        <div class="form-group flex flex-wrap mb-4">
                            <div class="w-full sm:w-1/2 px-2">
                                <label for="forma_pagamento" class="block text-sm font-medium text-yellow-500">Forma de Pagamento</label>
                                <select id="forma_pagamento" name="forma_pagamento" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-[#646cff] focus:ring-[#646cff] focus:ring-opacity-50" required>
                                    <option value="debito">Cartão de Débito</option>
                                    <option value="credito">Cartão de Crédito</option>
                                    <option value="pix">Pix</option>
                                    <option value="dinheiro">Dinheiro</option>
                                </select>
                            </div>

                            <div class="w-full sm:w-1/2 px-2">
                                <label for="desconto" class="block text-sm font-medium text-yellow-500">Desconto (%)</label>
                                <input type="number" id="desconto" name="desconto" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-[#646cff] focus:ring-[#646cff] focus:ring-opacity-50" placeholder="Digite o valor do desconto" min="0" max="100" value="0" oninput="calcularValorFinal()">
                            </div>
                        </div>

                        <div class="form-group flex flex-wrap mb-4">
                            <div class="w-full sm:w-1/2 px-2">
                                <label for="plano" class="block text-sm font-medium text-yellow-500">Plano*</label>
                                <select id="plano" name="plano_id" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-[#646cff] focus:ring-[#646cff] focus:ring-opacity-50" required onchange="calcularValorFinal()">
                                    @foreach($planos as $plano)
                                    <option value="{{ $plano->id }}" data-valor="{{ $plano->valor }}">{{ $plano->nome }} - R${{ number_format($plano->valor, 2, ',', '.') }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="w-full sm:w-1/2 px-2">
                                <label for="valor_final" class="block text-sm font-medium text-yellow-500">Valor Final (R$)</label>
                                <input type="text" id="valor_final" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-[#646cff] focus:ring-[#646cff] focus:ring-opacity-50" readonly>
                            </div>
                        </div>

                        <div class="form-group flex flex-wrap mb-4">
                            <div class="w-full px-2">
                                <button type="submit" class="bg-green-500 text-white font-bold py-2 px-4 rounded hover:bg-green-600">
                                    Finalizar Venda
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function calcularValorFinal() {
            var planoSelect = document.getElementById('plano');
            var planoSelecionado = planoSelect.options[planoSelect.selectedIndex];
            var valorPlano = parseFloat(planoSelecionado.getAttribute('data-valor'));

            var desconto = parseFloat(document.getElementById('desconto').value) || 0;

            var valorFinal = valorPlano - (valorPlano * desconto / 100);

            document.getElementById('valor_final').value = valorFinal.toFixed(2);
        }
        document.addEventListener('DOMContentLoaded', function() {
            calcularValorFinal();
        });
    </script>
</x-app-layout>