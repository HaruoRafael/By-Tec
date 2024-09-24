<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaixasTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('caixas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Relaciona com o usuário que abriu o caixa
            $table->dateTime('data_abertura'); // Data e hora de abertura
            $table->dateTime('data_fechamento')->nullable(); // Data e hora de fechamento, pode ser nulo
            $table->decimal('saldo_inicial', 10, 2); // Saldo inicial ao abrir o caixa
            $table->decimal('saldo_final', 10, 2)->nullable(); // Saldo final ao fechar o caixa
            $table->enum('status', ['aberto', 'fechado']); // Status do caixa (aberto ou fechado)
            $table->timestamps();

            // Chave estrangeira
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caixas');
    }
}
