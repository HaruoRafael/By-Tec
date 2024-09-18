<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;  // Importa o modelo User

class Venda extends Model
{
    use HasFactory;

    protected $fillable = ['descricao', 'data', 'valor', 'situacao', 'forma_pagamento', 'desconto', 'aluno_id', 'plano_id', 'user_id'];

    public function aluno()
    {
        return $this->belongsTo(Aluno::class);
    }

    public function plano()
    {
        return $this->belongsTo(Plano::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
