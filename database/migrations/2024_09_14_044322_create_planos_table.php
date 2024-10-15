<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanosTable extends Migration
{
    public function up()
    {
        Schema::create('planos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->decimal('valor', 10, 2);
            $table->integer('duracao'); // Ex: Duração em meses
            $table->boolean('ativo')->default(true); // Campo para controlar se o plano está ativo
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('planos');
    }
}
