<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendasTable extends Migration
{
    public function up()
    {
        Schema::create('vendas', function (Blueprint $table) {
            $table->id();
            $table->string('descricao');
            $table->date('data');  // Data da venda
            $table->date('data_inicio');  // Data de início do plano
            $table->decimal('valor', 10, 2);  // Valor final com desconto
            $table->string('forma_pagamento');  // Forma de pagamento
            $table->decimal('desconto', 5, 2)->default(0);  // Desconto
            $table->foreignId('user_id')->constrained()->onDelete('cascade');  // Relaciona com a tabela `users`
            $table->foreignId('aluno_id')->constrained()->onDelete('cascade');  // Relaciona com a tabela `alunos`
            $table->foreignId('plano_id')->constrained()->onDelete('cascade');  // Relaciona com a tabela `planos`
            $table->foreignId('caixa_id')->constrained()->onDelete('cascade');  // Relaciona com a tabela `caixas`
            $table->date('data_expiracao');  // Campo para armazenar a data de expiração do plano
            $table->enum('status', ['Ativo', 'Finalizado', 'Cancelado', 'Reembolsada'])->default('Ativo');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vendas');
    }
}
