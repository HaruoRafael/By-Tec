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
            $table->date('data');  
            $table->date('data_inicio');  
            $table->decimal('valor', 10, 2);  
            $table->string('forma_pagamento');  
            $table->decimal('desconto', 5, 2)->default(0);  
            $table->foreignId('user_id')->constrained()->onDelete('cascade');  
            $table->foreignId('aluno_id')->constrained()->onDelete('cascade'); 
            $table->foreignId('plano_id')->constrained()->onDelete('cascade');  
            $table->foreignId('caixa_id')->constrained()->onDelete('cascade');  
            $table->date('data_expiracao');  
            $table->enum('status', ['Ativo', 'Finalizado', 'Cancelado', 'Reembolsada'])->default('Ativo');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vendas');
    }
}
