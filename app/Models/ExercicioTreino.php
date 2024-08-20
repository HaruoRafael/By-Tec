<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExercicioTreino extends Model
{
    protected $table = 'exercicio_treino';

    protected $fillable = ['treino_id', 'exercicio_id', 'series', 'repeticoes'];
}
