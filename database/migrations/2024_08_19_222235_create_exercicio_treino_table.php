<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExercicioTreinoTable extends Migration
{
    public function up()
    {
        Schema::create('exercicio_treino', function (Blueprint $table) {
            $table->id();
            $table->foreignId('treino_id')->constrained()->onDelete('cascade');
            $table->foreignId('exercicio_id')->constrained()->onDelete('cascade');
            $table->integer('series');
            $table->integer('repeticoes');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('exercicio_treino');
    }
}
