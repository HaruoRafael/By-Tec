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
                    <h3 class="text-3xl font-bold mb-4">Estatísticas do Sistema</h3>

                    <div class="grid grid-cols-3 gap-6 text-center">
                        <div class="bg-[#474747] p-6 rounded-lg shadow-md">
                            <p class="text-sm font-semibold text-gray-400">Total de Alunos</p>
                            <p class="text-5xl font-bold">{{ $totalAlunos }}</p>
                        </div>
                        <div class="bg-[#474747] p-6 rounded-lg shadow-md">
                            <p class="text-sm font-semibold text-gray-400">Alunos Inativos</p>
                            <p class="text-5xl font-bold">{{ $alunosInativos }}</p>
                        </div>
                        <div class="bg-[#474747] p-6 rounded-lg shadow-md">
                            <p class="text-sm font-semibold text-gray-400">Alunos Ativos</p>
                            <p class="text-5xl font-bold">{{ $alunosAtivos }}</p>
                        </div>
                        <div class="bg-[#474747] p-6 rounded-lg shadow-md">
                            <p class="text-sm font-semibold text-gray-400">Status do Caixa</p>
                            <p class="text-2xl font-bold">{{ $mensagemCaixa }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
