<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateExerciciosTable extends Migration
{
    public function up()
    {
        
        Schema::create('exercicios', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('grupo_muscular');
            $table->enum('dificuldade', ['easy', 'normal', 'hard']);
            $table->text('observacoes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('exercicios');
        DB::statement('DROP EXTENSION IF EXISTS unaccent');

    }
}
