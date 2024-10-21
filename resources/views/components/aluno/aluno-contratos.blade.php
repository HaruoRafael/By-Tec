<div class="p-4 bg-[#2d2d2d] shadow-md rounded-md">
    <h3 class="text-lg font-semibold text-yellow-500">Histórico de Contratos</h3>

    
    @php
    $contratos = $aluno->vendas()->orderBy('created_at', 'desc')->get();
    @endphp

    @if($contratos->isEmpty())
    <p class="text-yellow-500">O aluno não possui nenhum contrato registrado.</p>
    @else
    <table class="table-auto w-full">
        <thead>
            <tr class="bg-[#2d2d2d]">
                <th class="px-4 py-2 text-left text-yellow-500">Plano</th>
                <th class="px-4 py-2 text-left text-yellow-500">Data de Início</th>
                <th class="px-4 py-2 text-left text-yellow-500">Data de Expiração</th>
                <th class="px-4 py-2 text-left text-yellow-500">Valor</th>
                <th class="px-4 py-2 text-left text-yellow-500">Status</th>
                <th class="px-4 py-2 text-left text-yellow-500">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contratos as $contrato)
            @php
            $data_inicio = \Carbon\Carbon::parse($contrato->data_inicio);
            $data_expiracao = \Carbon\Carbon::parse($contrato->data_expiracao);
            @endphp
            <tr class="bg-[#2d2d2d]">
                <td class="border px-4 py-2 text-yellow-500">{{ $contrato->plano->nome }}</td>
                <td class="border px-4 py-2 text-yellow-500">{{ $data_inicio->format('d/m/Y') }}</td>
                <td class="border px-4 py-2 text-yellow-500">{{ $data_expiracao->format('d/m/Y') }}</td>
                <td class="border px-4 py-2 text-yellow-500">R$ {{ number_format($contrato->valor, 2, ',', '.') }}</td>
                <td class="border px-4 py-2">
                    @if($contrato->status === 'Ativo')
                    <span class="text-green-500">Ativo</span>
                    @elseif($contrato->status === 'Finalizado')
                    <span class="text-blue-500">Finalizado</span>
                    @elseif($contrato->status === 'Cancelado')
                    <span class="text-red-500">Cancelado</span>
                    @elseif($contrato->status === 'Reembolsada')
                    <span class="text-yellow-500">Reembolsada</span>
                    @endif
                </td>
                <td class="border px-4 py-2">
                    <a href="{{ route('vendas.show', $contrato->id) }}" class="text-blue-500 hover:underline">
                        Ver Detalhes
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
