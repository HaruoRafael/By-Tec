<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-yellow-500 dark:text-yellow-500 leading-tight">
            {{ __('Abrir Caixa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#2d2d2d] overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-yellow-500 dark:text-yellow-500">
                    <h2 class="text-2xl font-bold mb-4">Abertura de Caixa</h2>

                    <form action="{{ route('caixas.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-4">
                            <label for="saldo_inicial" class="block text-sm font-medium text-yellow-500">Saldo Inicial*</label>
                            <input type="text" id="saldo_inicial" name="saldo_inicial" class="mt-1 block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" required>
                        </div>

                        <button type="submit" class="bg-green-500 text-white font-bold py-2 px-4 rounded hover:bg-green-600">Abrir Caixa</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const saldoInicialInput = document.getElementById('saldo_inicial');

            saldoInicialInput.addEventListener('input', function(e) {
                let value = e.target.value;

                value = value.replace(/\D/g, "");

                if (value.length > 2) {
                    value = value.slice(0, value.length - 2) + '.' + value.slice(value.length - 2);
                }

                e.target.value = value;
            });

            saldoInicialInput.value = '0.00';
        });
    </script>
</x-app-layout>
