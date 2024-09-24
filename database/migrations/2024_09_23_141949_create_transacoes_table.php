<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransacoesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transacoes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('caixa_id'); // Relaciona a transação com o caixa
            $table->enum('tipo', ['entrada', 'saida']); // Tipo de transação: entrada ou saída
            $table->decimal('valor', 10, 2); // Valor da transação
            $table->string('forma_pagamento'); // Método de pagamento (dinheiro, cartão, PIX, etc.)
            $table->text('descricao')->nullable(); // Descrição opcional da transação
            $table->timestamps();

            // Chave estrangeira
            $table->foreign('caixa_id')->references('id')->on('caixas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transacoes');
    }
}
