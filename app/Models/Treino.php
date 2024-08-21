<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Treino extends Model
{
    protected $fillable = ['nome', 'tipo', 'user_id', 'aluno_id'];

    public function exercicios()
    {
        return $this->belongsToMany(Exercicio::class)
                    ->withPivot('series', 'repeticoes')
                    ->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function alunos()
    {
        return $this->belongsToMany(Aluno::class);
    }
}

