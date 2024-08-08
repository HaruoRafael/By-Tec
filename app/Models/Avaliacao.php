<?php

// app/Models/Avaliacao.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avaliacao extends Model
{
    use HasFactory;
    protected $table = 'avaliacoes'; // Especificando o nome correto da tabela

    protected $fillable = [
        'avaliador',
        'data',
        'nome_aluno',
        'altura',
        'idade',
        'peso',
        'porcentagem_gordura',
        'braco_direito_gordura',
        'braco_esquerdo_gordura',
        'perna_direita_gordura',
        'perna_esquerda_gordura',
        'tronco_gordura',
        'massa_muscular',
        'braco_direito_muscular',
        'braco_esquerdo_muscular',
        'perna_direita_muscular',
        'perna_esquerda_muscular',
        'tronco_muscular',
        'massa_ossea',
        'gordura_visceral',
        'porcentagem_agua',
        'taxa_metabolica_basal',
        'idade_metabolica',
    ];
    public function aluno()
    {
        return $this->belongsTo(Aluno::class);
    }
}

