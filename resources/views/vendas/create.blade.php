<form action="{{ route('vendas.store') }}" method="POST">
    @csrf
    <input type="hidden" name="aluno_id" value="{{ $aluno->id }}">

    <!-- Descrição e Data continuam -->
    <div class="form-group">
        <label for="descricao">Descrição</label>
        <input type="text" id="descricao" name="descricao" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="data">Data</label>
        <input type="date" id="data" name="data" class="form-control" value="{{ date('Y-m-d') }}" required>
    </div>

    <!-- Formas de Pagamento -->
    <div class="form-group">
        <label for="forma_pagamento">Forma de Pagamento</label>
        <select id="forma_pagamento" name="forma_pagamento" class="form-control" required>
            <option value="debito">Cartão de Débito</option>
            <option value="credito">Cartão de Crédito</option>
            <option value="pix">Pix</option>
            <option value="dinheiro">Dinheiro</option>
        </select>
    </div>

    <!-- Desconto -->
    <div class="form-group">
        <label for="desconto">Desconto (%)</label>
        <input type="number" id="desconto" name="desconto" class="form-control" placeholder="Digite o valor do desconto" min="0" max="100" value="0">
    </div>

    <!-- Plano relacionado, não precisa de campo de valor -->
    <div class="form-group">
        <label for="plano">Plano</label>
        <select id="plano" name="plano_id" class="form-control" required>
            @foreach($planos as $plano)
            <option value="{{ $plano->id }}">{{ $plano->nome }} - R${{ number_format($plano->valor, 2, ',', '.') }}</option>
            @endforeach
        </select>
    </div>
    <!-- Quem realizou a venda -->

    <button type="submit" class="btn btn-primary">Finalizar Venda</button>
</form>