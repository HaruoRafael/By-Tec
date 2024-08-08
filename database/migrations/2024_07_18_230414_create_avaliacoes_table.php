<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('avaliacoes', function (Blueprint $table) {
            $table->id();
            $table->string('avaliador');
            $table->date('data');
            $table->float('altura');
            $table->integer('idade');
            $table->float('peso');
            $table->float('porcentagem_gordura');
            $table->float('braco_direito_gordura');
            $table->float('braco_esquerdo_gordura');
            $table->float('perna_direita_gordura');
            $table->float('perna_esquerda_gordura');
            $table->float('tronco_gordura');
            $table->float('massa_muscular');
            $table->float('braco_direito_muscular');
            $table->float('braco_esquerdo_muscular');
            $table->float('perna_direita_muscular');
            $table->float('perna_esquerda_muscular');
            $table->float('tronco_muscular');
            $table->float('massa_ossea');
            $table->float('gordura_visceral');
            $table->float('porcentagem_agua');
            $table->float('taxa_metabolica_basal');
            $table->integer('idade_metabolica');
            $table->foreignId('aluno_id')->constrained()->onDelete('cascade'); // Adicionando relação com aluno
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avaliacoes');
    }
};
