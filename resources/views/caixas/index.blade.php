@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Caixas</h1>

    <a href="{{ route('caixas.abrir') }}" class="btn btn-primary">Abrir Novo Caixa</a>

    <table class="table">
        <thead>
            <tr>
                <th>Responsável</th>
                <th>Data de Abertura</th>
                <th>Data de Fechamento</th>
                <th>Situação</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($caixas as $caixa)
            <tr>
                <td>{{ $caixa->responsavel }}</td>
                <td>{{ $caixa->data_abertura }}</td>
                <td>{{ $caixa->data_fechamento ?? 'Aberto' }}</td>
                <td>{{ $caixa->fechado ? 'Fechado' : 'Aberto' }}</td>
                <td>
                    <a href="{{ route('caixas.show', $caixa->id) }}" class="btn btn-info">Ver Detalhes</a>
                    @if(!$caixa->fechado)
                    <form action="{{ route('caixas.fechar', $caixa->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger">Fechar Caixa</button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
