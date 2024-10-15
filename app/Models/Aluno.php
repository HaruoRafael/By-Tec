<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'cpf',
        'rg',
        'telefone',
        'sexo',
        'data_nascimento',
        'endereco',
        'status'
    ];

    protected $dates = ['data_nascimento'];

    public function getIdadeAttribute()
    {
        if (is_string($this->data_nascimento)) {
            $this->data_nascimento = Carbon::parse($this->data_nascimento);
        }
        return optional($this->data_nascimento)->age;
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function avaliacoes()
    {   
        return $this->hasMany(Avaliacao::class);
    }

    public function treinos()
    {
        return $this->belongsToMany(Treino::class);
    }

    public function vendas()
    {
        return $this->hasMany(Venda::class);
    }

    public function planos()
    {
        return $this->hasManyThrough(Plano::class, Venda::class);
    }

    
}
