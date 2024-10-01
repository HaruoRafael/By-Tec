<div class="p-4 bg-white shadow-md rounded-md">
    <h3 class="text-lg font-semibold">Histórico de Contratos</h3>

    @php
    // Carrega os contratos (vendas) diretamente do modelo Aluno, ordenados por ordem de criação
    $contratos = $aluno->vendas()->orderBy('created_at', 'desc')->get();
    @endphp

    @if($contratos->isEmpty())
    <p>O aluno não possui nenhum contrato registrado.</p>
    @else
    <table class="table-auto w-full">
        <thead>
            <tr>
                <th class="px-4 py-2">Plano</th>
                <th class="px-4 py-2">Data de Início</th>
                <th class="px-4 py-2">Data de Expiração</th>
                <th class="px-4 py-2">Valor</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2">Ações</th> <!-- Nova coluna para Ações -->
            </tr>
        </thead>
        <tbody>
            @foreach($contratos as $contrato)
            @php
            $data_inicio = \Carbon\Carbon::parse($contrato->data);
            $data_expiracao = \Carbon\Carbon::parse($contrato->data_expiracao);
            @endphp
            <tr>
                <td class="border px-4 py-2">{{ $contrato->plano->nome }}</td>
                <td class="border px-4 py-2">{{ $data_inicio->format('d/m/Y') }}</td>
                <td class="border px-4 py-2">{{ $data_expiracao->format('d/m/Y') }}</td>
                <td class="border px-4 py-2">R$ {{ number_format($contrato->valor, 2, ',', '.') }}</td>
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
                    <!-- Link para o detalhe da venda -->
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
