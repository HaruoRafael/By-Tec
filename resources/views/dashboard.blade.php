<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-yellow-500 dark:text-yellow-500 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#2d2d2d] overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-yellow-500 dark:text-yellow-500">
                    <h3 class="text-2xl font-bold mb-4">Estatísticas do Sistema</h3>

                    <p>Quantidade total de alunos cadastrados: <strong>{{ $totalAlunos }}</strong></p>
                    <p>Quantidade de alunos ativos: <strong>{{ $alunosAtivos }}</strong></p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
