<div class="p-4 bg-white shadow-md rounded-md">
    <h3 class="text-lg font-semibold">Detalhes do Plano</h3>

    @if($aluno->vendas->isNotEmpty())
    @php
    // Pega a última venda realizada (pode estar ativa, finalizada, cancelada ou reembolsada)
    $venda_atual = $aluno->vendas->last();
    $data_inicio = \Carbon\Carbon::parse($venda_atual->data_inicio);
    $data_expiracao = \Carbon\Carbon::parse($venda_atual->data_expiracao);
    @endphp

    <p>Plano: <strong>{{ $venda_atual->plano->nome }}</strong></p>
    <p>Data de Início: <strong>{{ $data_inicio->format('d/m/Y') }}</strong></p>
    <p>Data de Expiração: <strong>{{ $data_expiracao->format('d/m/Y') }}</strong></p>
    <p>Valor: R$ {{ number_format($venda_atual->valor, 2, ',', '.') }}</p>

    <!-- Verificação do status da venda -->
    @if($venda_atual->status === 'Ativo')
    <p>Status: <span class="text-green-500">Ativo</span></p>
    @elseif($venda_atual->status === 'Finalizado')
    <p>Status: <span class="text-blue-500">Finalizado</span></p>
    @elseif($venda_atual->status === 'Cancelado')
    <p>Status: <span class="text-red-500">Cancelado</span></p>
    @elseif($venda_atual->status === 'Reembolsada')
    <p>Status: <span class="text-yellow-500">Reembolsado</span></p>
    @endif

    <!-- Mostrar os botões apenas se o status for Ativo -->
    @if($venda_atual->status === 'Ativo')
    <div class="mt-4 flex space-x-4">
        <!-- Formulário para Finalizar o Plano -->
        <form action="{{ route('vendas.finalizar', $venda_atual->id) }}" method="POST">
            @csrf
            @method('POST')
            <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-700">
                Finalizar Plano
            </button>
        </form>

        <!-- Formulário para Cancelar o Plano -->
        <form action="{{ route('vendas.cancelar', $venda_atual->id) }}" method="POST">
            @csrf
            @method('DELETE')
        </form>
    </div>
    @endif

    @else
    <p>O aluno não possui um plano ativo no momento.</p>
    @endif
</div>