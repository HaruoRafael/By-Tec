@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalhes do Caixa</h1>

    <div>
        <p>Responsável: {{ $caixa->responsavel }}</p>
        <p>Data de Abertura: {{ $caixa->data_abertura }}</p>
        <p>Entradas: R${{ number_format($caixa->entradas, 2, ',', '.') }}</p>
        <p>Saídas: R${{ number_format($caixa->saidas, 2, ',', '.') }}</p>
        <p>Saldo Final: {{ $caixa->fechado ? 'R$' . number_format($caixa->saldo_final, 2, ',', '.') : 'Em Aberto' }}</p>
    </div>

    <h2>Movimentações</h2>
    <a href="{{ route('caixas.movimentacao', $caixa->id) }}" class="btn btn-primary">Adicionar Movimentação</a>

    <table class="table">
        <thead>
            <tr>
                <th>Data</th>
                <th>Tipo</th>
                <th>Origem</th>
                <th>Método</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>
            @foreach($caixa->movimentacoes as $movimentacao)
            <tr>
                <td>{{ $movimentacao->created_at }}</td>
                <td>{{ $movimentacao->tipo }}</td>
                <td>{{ $movimentacao->origem }}</td>
                <td>{{ $movimentacao->metodo }}</td>
                <td>R${{ number_format($movimentacao->valor, 2, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
