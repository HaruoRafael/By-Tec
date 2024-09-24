<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transacao extends Model
{
    use HasFactory;

    protected $fillable = [
        'caixa_id',
        'tipo',
        'valor',
        'forma_pagamento',
        'descricao',
    ];

    // Relacionamento com o caixa
    public function caixa()
    {
        return $this->belongsTo(Caixa::class);
    }
}
