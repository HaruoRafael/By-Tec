<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imprimir Detalhes do Caixa</title>
    <style>
        body { font-family: Arial, sans-serif; color: #333; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>
    <h1>Detalhes do Caixa #{{ $caixa->id }}</h1>

    <p><strong>Data de Abertura:</strong> {{ \Carbon\Carbon::parse($caixa->data_abertura)->format('d/m/Y H:i') }}</p>
    <p><strong>Data de Fechamento:</strong> {{ $caixa->data_fechamento ? \Carbon\Carbon::parse($caixa->data_fechamento)->format('d/m/Y H:i') : 'Em aberto' }}</p>
    <p><strong>Status:</strong> {{ ucfirst($caixa->status) }}</p>
    <p><strong>Saldo Inicial:</strong> R$ {{ number_format($caixa->saldo_inicial, 2, ',', '.') }}</p>

    @php
    $totalVendasAtivasOuFinalizadas = $vendas->whereIn('status', ['Ativo', 'Finalizado'])->sum('valor');
    $saldoCalculado = $caixa->saldo_inicial + $totalVendasAtivasOuFinalizadas;
    @endphp

    <p><strong>Saldo Calculado (Com Vendas):</strong> R$ {{ number_format($saldoCalculado, 2, ',', '.') }}</p>

    <h2>Vendas</h2>
    @if($vendas->isEmpty())
        <p>Nenhuma venda registrada neste caixa.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Descrição</th>
                    <th>Valor</th>
                    <th>Data</th>
                    <th>Forma de Pagamento</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vendas as $venda)
                <tr>
                    <td>{{ $venda->descricao }}</td>
                    <td>R$ {{ number_format($venda->valor, 2, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($venda->created_at)->format('d/m/Y H:i') }}</td>
                    <td>{{ ucfirst($venda->forma_pagamento) }}</td>
                    <td>{{ $venda->status }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
